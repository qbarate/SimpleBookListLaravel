// TODO Document all this javascript
var books = []; // TODOQBA Voir si on conserve ça
var booksToDisplay = [];

function deleteFormatter(value, row, index) {
    return '<a href="/Book/Update/' + value + '"><img class="updateIcon" src="' + penUrl + '"/></a> \
            <a href="/Book/Delete/' + value + '"><img class="deleteIcon" src="' + binUrl + '"/></a>';
}

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

function loadAndDisplayBooks() {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/Book/List",
        context: document.body,
        success: function(data) {
            books = data;
            booksToDisplay = books;
            displayBooks();
        },
        error: function(data) {
            alert("Error: " + data.status);
        }
    });
}

function generateDownloadButton(fileContent, exportType) {
    var exportData = new Blob([fileContent], {type: 'text/plain'});
    var url = window.URL.createObjectURL(exportData);

    $("#downloadExport").attr("download", "export." + exportType);
    $("#downloadExport").attr("href", url);
    $("#downloadExport").html('<button type="button" class="btn btn-primary">Download ' + exportType.toUpperCase() + '</button>');
    $("#downloadExport").show();
}

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