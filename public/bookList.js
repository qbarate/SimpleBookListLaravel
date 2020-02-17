var booksToDisplay = [];

/**
 * Defines the content of the action column of the book display (with 'Edit' and 'Delete' buttons)
 * @param {*} value Id of the book (corresponds to the BookId field)
 * @param {*} row Full Book object
 * @param {*} index Index of the book in the table
 */
function deleteFormatter(value, row, index) {
    return '<a href="/Book/Update/' + value + '"><img class="updateIcon" src="' + penUrl + '"/></a> \
            <a onClick="confirmDelete(' + value + ')" href="#"><img class="deleteIcon" src="' + binUrl + '"/></a>';
}

/**
 * Fills and displays the delete confirmation modal.
 * @param {*} bookToDeleteId Id of the book to delete.
 */
function confirmDelete(bookToDeleteId) {
    var bookData = booksToDisplay.find(book => book.BookId == bookToDeleteId);

    $("#bookIdToDelete").val(bookToDeleteId);
    $("#bookNameToDelete").html(bookData.BookName);
    $('#confirmDeleteModal').modal('show');
}

/**
 * Sets-up the bootstrap table to display the queried list of books.
 */
function displayBooks() {
    $('#bookList').bootstrapTable({
        search: true,
        columns: [{
            field: 'BookId',
            title: '#',
            class: 'bookId',
            sortable: true,
        },{
            field: 'BookName',
            title: 'Title',
            sortable: true,
        }, {
            field: 'AuthorName',
            title: 'Author',
            sortable: true
        }, {
            field: 'Delete',
            title: '',
            sortable: false,
            field: 'BookId',
            formatter: deleteFormatter,
            width: 84
        }],
        data: booksToDisplay
    });
}

/**
 * Asynchronously loads the list of books from the back-end and displays them all.
 */
function loadAndDisplayBooks() {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/Book/List",
        context: document.body,
        success: function(data) {
            booksToDisplay = data;
            displayBooks();
        },
        error: function(data) {
            alert("Error: " + data.status);
        }
    });
}

/**
 * Generates the download button for the selected export.
 * @param {string} fileContent Plaintext to write to the file download
 * @param {string} exportType Either 'xml' or 'csv' depending on the export.
 */
function generateDownloadButton(fileContent, exportType) {
    var exportData = new Blob([fileContent], {type: 'text/plain'});
    var url = window.URL.createObjectURL(exportData);

    $("#downloadExport").attr("download", "export." + exportType);
    $("#downloadExport").attr("href", url);
    $("#downloadExport").html('<button type="button" class="btn btn-primary">Download ' + exportType.toUpperCase() + '</button>');
    $("#downloadExport").show();
}

/**
 * Exports the currently filtered books as a CSV file.
 */
function exportCSV() {
    var dataToExport = $("#fieldsToExport input[type='checkbox']:checked").map(function () {return $(this).val()}).toArray();
    var booksToExport = $('#bookList').bootstrapTable('getData');
    
    if (dataToExport.length == 0 || booksToExport.length == 0) {
        alert("No data to export.");
        return;
    }

    var csvLines = [];

    // We build the header line of the csv file
    csvLines.push(dataToExport.join(","));

    booksToExport.forEach(book => {
        var rowValuesToExport = [];
        dataToExport.forEach(column => {
            // Value is put between quotes in case it contains a comma (which would break the csv formatting)
            rowValuesToExport.push("\"" + book[column] + "\"");
        });
        csvLines.push(rowValuesToExport.join(','));
    });

    var fileContent = csvLines.join('\n');
    generateDownloadButton(fileContent, "csv");
}

/**
 * Exports the currently filtered books as a XML file.
 */
function exportXML(exportedObject) {
    var dataToExport = $("#fieldsToExport input[type='checkbox']:checked").map(function () {return $(this).val()}).toArray();
    var booksToExport = $('#bookList').bootstrapTable('getData');

    if (dataToExport.length == 0 || booksToExport.length == 0) {
        alert("No data to export.");
        return;
    }

    var xmlElements = [];
    xmlElements.push('<Export>');

    booksToExport.forEach(book => {
        var xmlElementNodes = [];
        xmlElements.push("<" + exportedObject + ">");

        dataToExport.forEach(column => {
            xmlElementNodes.push("<" + column + ">");
            xmlElementNodes.push(book[column]);
            xmlElementNodes.push("</" + column + ">");
        });
        xmlElements.push(xmlElementNodes.join(''));

        xmlElements.push("</" + exportedObject + ">");
    });
    xmlElements.push('</Export>');

    var fileContent = xmlElements.join('');
    generateDownloadButton(fileContent, "xml");
}

$(document).ready( function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadAndDisplayBooks();
});