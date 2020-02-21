var booksToDisplay = [];

/**
 * Defines the content of the action column of the book display (with 'Edit' and 'Delete' buttons)
 * @param {*} value Id of the book (corresponds to the BookId field)
 * @param {*} row Full Book object
 * @param {*} index Index of the book in the table
 */
function deleteFormatter(value, row, index) {
    return '<a href="/books/' + value + '/edit"><img class="updateIcon" src="' + penUrl + '"/></a> \
            <a onClick="confirmDelete(' + value + ')" href="#"><img class="deleteIcon" src="' + binUrl + '"/></a>';
}

/**
 * Fills and displays the delete confirmation modal.
 * @param {*} bookToDeleteId Id of the book to delete.
 */
function confirmDelete(bookToDeleteId) {
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
    $('#bookList').tableExport({
        type: 'csv',
        ignoreColumn: ['Id']
    });
}

/**
 * Exports the currently filtered books as a XML file.
 */
function exportXML(exportedObject) {
    $('#bookList').tableExport({
        type: 'xml',
        ignoreColumn: ['Id']
    });
}


$(document).ready( function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadAndDisplayBooks();
});