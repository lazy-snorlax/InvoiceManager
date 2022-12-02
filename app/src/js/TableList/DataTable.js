import React from "react";
import $ from "jquery";
import "datatables.net-dt/css/jquery.dataTables.css";
require("datatables.net");

export default class DataTable extends React.Component {
  constructor(props) {
    super(props);
    this.datatable = null;
  }
  componentDidMount() {
    this.$el = $(this.el);
    let pk = this.props.pk;
    let route = this.props.route;
    let cRoute = this.props.cRoute;
    console.log("PK: ", pk);
    this.dataTable = this.$el.DataTable({
      data: this.props.data,
      columns: this.props.columns,
      ...this.props.options,

      rowCallback(row, data, index) {
        console.log(">>> Rowcallback", row);
      },
      drawCallback(settings) {
        console.log(">>> DrawCallback", settings);
        document.querySelectorAll(`.editentry`).forEach((btn) => {
          btn.onclick = () => {
            let rowid = this.DataTable().row(btn.closest("tr")).data()[pk];
            console.log(">>>Edit Entry Clicked", rowid);

            if (cRoute) {
              window.open(cRoute + "/" + rowid, "_blank");
              return;
            }
            getData(rowid, route).then((row) => {
              console.log(">>> Selected row", row.data);
            });
          };
        });
      },
    });
  }

  componentWillUnmount() {
    this.dataTable.destroy(true);
  }

  // connecting search to an external component, optional but shows how to access the API
  search = (value) => {
    this.dataTable.search(value).draw();
  };

  render() {
    return (
      <div className="container">
        <table ref={(el) => (this.el = el)} className="w-full" />
      </div>
    );
  }
}

async function getData(id, url) {
  const response = await fetch(url + "/" + id);
  const data = await response.json();
  if (response.status != 200) {
    console.log(data);
    return false;
  }

  return data;
}
