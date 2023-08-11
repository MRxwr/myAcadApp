/* DataTable Initialization */

"use strict";

$(document).ready(function () {
  // Initialize DataTable for table with ID "myTable"
  $("#myTable").DataTable({
    columnDefs: [{ targets: 0, type: "date-euro" }],
    order: [0, "desc"],
    lengthChange: false, // Disable length change
  });

  // Initialize DataTable for table with ID "myTable1"
  $("#myTable1").DataTable({
    columnDefs: [{ targets: 0, type: "date-euro" }],
    order: [0, "asc"],
    lengthChange: false, // Disable length change
  });
});