import React from "react";
import { useState, useEffect } from "react";
import { renderToString } from "react-dom/server";
import axios from "axios";
// import TableRow from "./TableRow";
import DataTable from "./DataTable";

function Table({ route }) {
  const [error, setError] = useState(null);
  const [isLoaded, setIsLoaded] = useState(false);
  const [items, setItems] = useState([]);
  const [columns, setColumns] = useState([]);
  const [options, setOptions] = useState([]);
  const [dataTableRef, setDatatableRef] = useState();
  const [isPK, setIsPK] = useState();
  const [form, setForm] = useState([]);
  const [cRoute, setCRoute] = useState();

  useEffect(() => {
    const fetchData = async () => {
      const result = await axios(route);
      const form = await fetch(
        route.replace("data", "form").replace("/id", "")
      ).then((res) => res.text());

      let res = result.data;
      console.log("Result: ", result);
      setIsLoaded(true);
      setItems(res.data);
      setColumns(
        setUpColumns(
          res.columns,
          res.permissions.isEdit,
          res.permissions.isDelete,
          res.route
        )
      );
      setOptions([
        {
          dom: '<"wrapper"><"top"lf>t<"bottom"ip>',
        },
      ]);
      setIsPK(res.primarykey);
      setDatatableRef(React.createRef());
      setCRoute(res.route);

      // console.log(">>> Form", form);
      setForm(form);
    };

    fetchData();
  }, []);

  if (error) {
    return <div className="">Error: {error.message}</div>;
  } else if (!isLoaded) {
    return <div> Loading... </div>;
  } else {
    console.log(">>> Columns: ", columns);
    return (
      <>
        <div className="container">
          <DataTable
            ref={dataTableRef}
            columns={columns}
            options={options}
            data={items}
            pk={isPK}
            route={route}
            cRoute={cRoute}
          />
        </div>
        {/* <div className="container">
          <input type="checkbox" id="formModal" className="modal-toggle" />
          <div className="modal">
            <div className="modal-box w-11/12 max-w-5xl">
              <label
                htmlFor="formModal"
                className="btn btn-sm btn-circle absolute right-2 top-2"
              >
                ✕
              </label>
              <div
                id="modalBody"
                dangerouslySetInnerHTML={{ __html: form }}
              ></div>
            </div>
          </div>
        </div> */}
      </>
    );
  }
}

function setUpColumns(columns, isEdit = true, isDelete = true, route = null) {
  return columns
    .map((col) => {
      if (col.type) {
        switch (col.type) {
          case "boolean":
            col.render = (data, type, row, meta) => {
              let d = data == "1" || data == "1.0" ? "Y" : "N";
              return renderToString(<span className="center">{d}</span>);
            };
            break;

          case "number":
            col.render = (data, type, row, meta) => {
              let d = parseInt("0" + data);
              return renderToString(<span className="right">{d}</span>);
            };
            break;

          case "percent":
            col.render = (data, type, row, meta) => {
              let d = Number(data);
              return renderToString(
                <span className="right">{(d * 100).toFixed(2)}%</span>
              );
            };
            break;

          default:
            col.render = (data, type, row, meta) => {
              return renderToString(<span className="left">{data}</span>);
            };
            return col;
        }
      }
      return col;
    })
    .concat(
      isEdit || isDelete
        ? [
            {
              title: "",
              data: "",
              render: (data, type, row, meta) => {
                let btns = "";

                if (isEdit) {
                  if (route !== null) {
                    btns += `<button type="button" class="btn btn-primary ml-1 editentry">&#x1F5D7;</button>`;
                  } else {
                    btns += `<label for="formModal" type="button" class="btn btn-primary ml-1 editentry">&#x1F5D7;</label>`;
                  }
                }
                if (isDelete) {
                  btns += `<button type="button" class="btn btn-outline btn-error mr-1">X</button>`;
                }
                return btns.length > 0
                  ? `<div class="btn-group">${btns}</div>`
                  : "";
              },
            },
          ]
        : []
    );
}

export default Table;
