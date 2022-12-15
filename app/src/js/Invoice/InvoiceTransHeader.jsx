import React, { useState, useEffect } from "react";
import axios from "axios";
import InvoiceTransLines from "./InvoiceTransLines";

function InvoiceTransHeader({ transid, trans, route }) {
  // console.log(">>> ", trans, route);
  const [id, setId] = useState();
  const [tranhead, setTranHead] = useState([]);
  const [tranlines, setLines] = useState([]);
  const [gst, setGst] = useState();
  const [credit, setCredit] = useState();
  const [total, setTotal] = useState();
  const [head, setHead] = useState({ id: "", text: "" });

  useEffect(() => {
    async function fetchHeadLines(lineId) {
      const tblLines = await axios(route.head + "?id=" + lineId);
      setTranHead(tblLines.data.head);
    }
    fetchHeadLines(transid);
  }, []);

  const openModal = () => {
    let input = document.querySelector("#transHeadName");
    console.log(">>> Testing", head);
    if (head.text != "") {
      input.value = head.text;
    } else {
      input.value = "";
    }
    document.querySelector("#invoiceTransHead").click();
  };

  async function fetchTranLines(lineId) {
    const tblLines = await axios(route.lines + "?id=" + lineId);
    setLines(tblLines.data.lines);
    setGst(tblLines.data.gstTotal);
    setCredit(tblLines.data.creditTotal);
    setTotal(tblLines.data.total);
  }

  async function loadTranLines(lineId) {
    return (
      <InvoiceTransLines
        lineId={lineId}
        route={route}
        lines={tranlines}
        routeExpcodes={route.expensecodes}
      />
    );
  }

  function toggleActive(e) {
    let activeRow = e.target;
    activeRow = activeRow.closest("tr");
    let previousRow = document.querySelector("#transheader tr.active");
    if (previousRow && previousRow.classList.contains("active")) {
      previousRow.classList.toggle("active");
    }
    activeRow.classList.toggle("active");
  }

  const saveTitle = () => {
    console.log(">>> Head", head);
    axios
      .post(route.titlesave, {
        id: head.id,
        Transactionno: transid,
        TitleDescription: head.text,
      })
      .then((res) => {
        console.log(res);
        // fetchHeadLines(transid);
        setTranHead(res.data.titles);
      })
      .catch((error) => {
        console.log(error);
      });
    setHead({ id: "", text: "" });
  };

  return (
    <>
      <div className="overflow-x-auto h-60">
        <table className="table table-normal w-full" id="transheader">
          <thead>
            <tr>
              <th>No</th>
              <th>TitleDescription</th>
              <th className="text-right">
                <label
                  // htmlFor="invoiceTransHead"
                  className="btn btn-primary"
                  onClick={() => {
                    setHead({ id: "0", text: "" });
                    openModal();
                  }}
                >
                  +
                </label>
              </th>
            </tr>
          </thead>
          <tbody>
            {tranhead.map((tran) => (
              <tr
                className="hover"
                key={tran.TitleNo}
                onClick={(e) => {
                  toggleActive(e);
                  let id = e.target.closest("tr").children[0].innerText;
                  let text = e.target.closest("tr").children[1].innerText;
                  setId(id);
                  setHead({ id: id, text: text });
                  // loadTranLines(tran.TitleNo);
                }}
                onDoubleClick={(e) => {
                  // console.log("Target", text);
                  openModal();
                }}
              >
                <td>{tran.TitleNo}</td>
                <td colSpan={2}>{tran.TitleDescription}</td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>

      <input type="checkbox" id="invoiceTransHead" className="modal-toggle" />
      <div className="modal">
        <div className="modal-box">
          <label
            htmlFor="invoiceTransHead"
            className="btn btn-sm btn-circle absolute right-2 top-2"
          >
            ✕
          </label>
          <h3 className="font-bold text-lg">Enter New Address:</h3>
          <div className="py-4 w-full">
            <label htmlFor="" className="label">
              New Address
            </label>
            <input
              type="text"
              id="transHeadName"
              className="input input-bordered w-full"
              onChange={() => {
                let input = document.querySelector("#transHeadName").value;
                setHead({ id: head.id, text: input });
              }}
            />
          </div>
          <div className="modal-action">
            <label
              htmlFor="invoiceTransHead"
              className="btn btn-primary"
              onClick={() => {
                saveTitle();
              }}
            >
              Save
            </label>
          </div>
        </div>
      </div>

      <br />

      <InvoiceTransLines
        lineId={id != undefined ? id : 0}
        route={route}
        lines={tranlines}
        routeExpcodes={route.expensecodes}
      />
    </>
  );
}

export default InvoiceTransHeader;
