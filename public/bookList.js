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
    console.log(bookToDeleteId);
    var bookData = booksToDisplay.find(book => book.Id == bookToDeleteId);

    $("#bookIdToDelete").val(bookToDeleteId);
    $("#bookNameToDelete").html(bookData.Name);
    $('#confirmDeleteModal').modal('show');
}

/**
 * Sets-up the bootstrap table to display the queried list of books.
 */
function displayBooks() {
    $('#bookList').bootstrapTable({
        search: true,
        columns: [{
            field: 'Id',
            title: '#',
            class: 'bookId',
            sortable: true,
        },{
            field: 'Name',
            title: 'Title',
            sortable: true,
        }, {
            field: 'author.Name',
            title: 'Author',
            sortable: true
        }, {
            field: 'Delete',
            title: '',
            sortable: false,
            field: 'Id',
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
        url: "/books",
        context: document.body,
        success: function(data) {
            console.log(data);
            booksToDisplay = data;
            displayBooks();
        },
        error: function(data) {
            console.log(data.responseText);
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
 * Array taken from: https://dracoblue.net/dev/encodedecode-special-xml-characters-in-javascript/
 * I only completed it with the apostrophe
 */
var xml_special_to_escaped_one_map = {
    '&': '&amp;',
    '"': '&quot;',
    '<': '&lt;',
    '>': '&gt;',
    "'": '&apos'
};

/**
 * Code taken from: https://dracoblue.net/dev/encodedecode-special-xml-characters-in-javascript/
 * Encodes the XML special characters so the attributes to export won't break the XML format.
 * @param {*} string Text to encode
 */
function encodeXml(string) {
    return string.replace(/([\&"<>])/g, function(str, item) {
        return xml_special_to_escaped_one_map[item];
    });
};

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
            xmlElementNodes.push(encodeXml(book[column]));
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