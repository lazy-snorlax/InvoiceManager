import React, { useState } from "react";
import $ from "jquery";
import "datatables.net-dt/css/jquery.dataTables.css";
require("datatables.net");

// function DataTable({ columns, options }) {
//   console.log(">>>>Testing Columns", columns, refer);
//   const [dataTable, setDatatable] = useState();

//   const componentDidMount = () => {
//     this.$el = $(this.el);
//     this.dataTable = this.$el.DataTable({
//       data: this.props.data,
//       columns: this.props.columns,
//       ...this.props.options,
//     });
//   };

//   const componentWillUnmount = () => {
//     this.dataTable.destroy(true);
//   };

//   const search = (value) => {
//     this.dataTable.search(value).draw();
//   };

//   return <table />;
// }

// export default DataTable;
