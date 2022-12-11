import React from "react";
import { useState, setState, useEffect } from "react";
import { renderToString } from "react-dom/server";
import axios from "axios";
import InvoiceTransHeader from "./InvoiceTransHeader";
import InvoiceTransLines from "./InvoiceTransLines";

function InvoiceForm({ route, data, trans }) {
  // console.log(data, trans);
  const [invType, setInvType] = useState([]);
  const [companies, setCompanies] = useState([]);
  const [business, setBusiness] = useState([]);
  const [expensecodes, setExpensecodes] = useState([]);
  const [startDate, setStartDate] = useState();

  // console.log(">>> Routes", route);

  useEffect(() => {
    const fetchData = async () => {
      const tblCompanies = await axios(route.companies);
      const tblTypes = await axios(route.types);
      const tblBusiness = await axios(route.business);
      const tblExpensecodes = await axios(route.expensecodes);

      console.log(tblTypes.data, tblCompanies.data, tblBusiness.data);
      setInvType(tblTypes.data.data);
      setCompanies(tblCompanies.data.companies);
      setBusiness(tblBusiness.data.data);
      setExpensecodes(tblExpensecodes.data.data);
      // console.log(invType, companies, business);
    };

    fetchData();
  }, []);

  return (
    <div>
      <form data-name="Tabletransactionmain">
        <div className="flex space-x-4">
          <div className="mb-4 w-1/4" hidden>
            <label className="label" htmlFor="TransactionId">
              <span className="label-text">Transaction Id</span>
            </label>
            <input
              className="input input-bordered w-full"
              type="number"
              disabled
              name="TransactionId"
              data-type="integer"
              required="required"
              defaultValue={data.TransactionId}
            />
          </div>
          <div className="mb-4 w-3/4">
            <label className="label" htmlFor="CompanyNo">
              <span className="label-text">Company No</span>
            </label>
            <select
              className="input input-bordered w-full"
              type="number"
              name="CompanyNo"
              data-type="integer"
              value={data.CompanyNo ? data.CompanyNo : ""}
              onChange={() => console.log("changedCompanyNo")}
            >
              {companies.map((company) => (
                <option key={company.CompanyId} value={company.CompanyId}>
                  {company.CompanyName}
                </option>
              ))}
            </select>
          </div>
          <div className="mb-4 w-1/4">
            <label className="label" htmlFor="Date">
              <span className="label-text">Date</span>
            </label>
            <input
              className="input input-bordered w-full"
              type="date"
              name="Date"
              data-type="datetime"
              defaultValue={
                data.Date ? data.Date.split("-").reverse().join("-") : startDate
              }
            />
          </div>
          {/* <div className="mb-4 w-1/4">
            <label className="label" htmlFor="Days">
              <span className="label-text">Days</span>
            </label>
            <input
              className="input input-bordered w-full"
              type="date"
              name="Days"
              data-type="datetime"
              defaultValue={
                data.Date ? data.Date.split("-").reverse().join("-") : startDate
              }
            />
          </div> */}
        </div>
        <div className="flex space-x-20">
          <div className="mb-4 w-1/3">
            <label className="label" htmlFor="Type">
              <span className="label-text">Type</span>
            </label>
            <select
              className="input input-bordered w-full"
              name="Type"
              data-type="integer"
              value={data.Type ? data.Type : ""}
              onChange={() => console.log("changedType")}
            >
              {invType.map((type) => (
                <option key={type.TypeCode} value={type.TypeCode}>
                  {type.TypeDescription}
                </option>
              ))}
            </select>
          </div>
          <div className="mb-4 w-1/3">
            <label className="label" htmlFor="OrderNo">
              <span className="label-text">Order No</span>
            </label>
            <input
              className="input input-bordered w-full"
              type="number"
              name="OrderNo"
              data-type="integer"
              defaultValue={data.OrderNo ? data.OrderNo : ""}
            />
          </div>
          <div className="mb-4 w-1/3">
            <label className="label" htmlFor="Paid">
              <span className="label-text">Paid</span>
            </label>
            <select
              className="input input-bordered w-full"
              name="Paid"
              data-type="boolean"
              defaultValue={data.Paid ? data.Paid : ""}
              onChange={() => console.log("changedPaid")}
            >
              <option value="false">No</option>
              <option value="true">Yes</option>
            </select>
          </div>
        </div>

        <div className="flex space-x-10">
          <div className="mb-4 w-1/2">
            <label className="label" htmlFor="BusinessNo">
              <span className="label-text">Business No</span>
            </label>
            <select
              className="input input-bordered w-full"
              name="BusinessNo"
              data-type="integer"
              defaultValue={data.BusinessNo ? data.BusinessNo : ""}
              onChange={() => console.log("changedBusinessNo")}
            >
              <option value="0">G & R Morelli</option>
            </select>
          </div>
          <div className="mb-4 w-1/2">
            <label className="label" htmlFor="PaymentDetail">
              <span className="label-text">Payment Detail</span>
            </label>
            <input
              className="input input-bordered w-full"
              type="text"
              name="PaymentDetail"
              data-type="varchar"
              defaultValue={data.PaymentDetail ? data.PaymentDetail : ""}
            />
          </div>
        </div>
        <div className="flex">
          <div className="mb-4 w-full">
            <label className="label" htmlFor="Note">
              <span className="label-text">Note</span>
            </label>
            <input
              className="input input-bordered w-full"
              type="text"
              name="Note"
              data-type="varchar"
              defaultValue={data.Note ? data.Note : ""}
            />
          </div>
        </div>

        <InvoiceTransHeader trans={trans} />
        <br />
        <br />
        <InvoiceTransLines trans={trans} expensecodes={expensecodes} />
      </form>
    </div>
  );
}

export default InvoiceForm;
