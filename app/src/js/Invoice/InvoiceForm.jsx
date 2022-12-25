import React from "react";
import { useState, useEffect } from "react";
import axios from "axios";
import InvoiceTransHeader from "./InvoiceTransHeader";

function InvoiceForm({ route, data, trans }) {
  // console.log(data, trans);
  const [main, setMain] = useState([]);
  const [invType, setInvType] = useState([]);
  const [companies, setCompanies] = useState([]);
  const [business, setBusiness] = useState([]);
  const [credit, setCredit] = useState([]);
  // const [expensecodes, setExpensecodes] = useState([]);
  const [startDate, setStartDate] = useState();

  // console.log(">>> Routes", route);

  useEffect(() => {
    setMain(data);
    let date = new Date();
    setStartDate(date.toISOString().split("T")[0]);
    const fetchData = async () => {
      const tblCompanies = await axios(route.companies + "?type=customers");
      const tblTypes = await axios(route.types);
      const tblBusiness = await axios(route.business);
      const tblCredit = await axios(route.credit);
      // const tblExpensecodes = await axios(route.expensecodes);

      // console.log(tblTypes.data, tblCompanies.data, tblBusiness.data);
      setInvType(tblTypes.data.data);
      setCompanies(tblCompanies.data.companies);
      setBusiness(tblBusiness.data.data);
      setCredit(tblCredit.data.data);
      // setExpensecodes(tblExpensecodes.data.data);
      // console.log(invType, companies, business);
    };

    fetchData();
  }, []);

  const saveOnChange = () => {
    let form = document.querySelector("#invoiceHead");
    let formData = new FormData(form);

    axios
      .post(route.save, formData)
      .then((response) => {
        console.log(response);
        if (response.error) {
          alert(response.error);
          return;
        }
        setMain(response.data.data);
        let url = window.location.href;
        if (url.includes("/new")) {
          window.history.replaceState(
            null,
            "GR Morelli Business Management System",
            url.replace("/new", `/${response.data.data.TransactionId}`)
          );
        }
      })
      .catch((error) => {
        console.log(error);
      });
  };

  return (
    <div>
      <form
        data-name="Tabletransactionmain"
        id="invoiceHead"
        onChange={saveOnChange}
      >
        <div className="flex space-x-4 mx-auto text-center">
          <div className="mb-4 w-1/4 mx-auto">
            <a
              href={window.location.href + "?doPDF=true"}
              target="_blank"
              className="btn btn-primary"
            >
              Preview Invoice
            </a>
          </div>
        </div>
        <div className="flex space-x-4">
          <div className="mb-4 w-1/4" hidden>
            <label className="label" htmlFor="TransactionId">
              <span className="label-text">Transaction Id</span>
            </label>
            <input
              className="input input-bordered w-full"
              type="number"
              name="TransactionId"
              data-type="integer"
              required="required"
              defaultValue={main.TransactionId}
            />
          </div>
          <div className="mb-4 w-2/4">
            <label className="input-group" htmlFor="CompanyNo">
              <span className="label-text">Company</span>
              <select
                className="input input-bordered w-full"
                type="number"
                name="CompanyNo"
                data-type="integer"
                value={main.CompanyNo ? main.CompanyNo : ""}
                onChange={() => console.log("changedCompanyNo")}
              >
                <option value=""></option>
                {companies.map((company) => (
                  <option key={company.CompanyId} value={company.CompanyId}>
                    {company.CompanyName}
                  </option>
                ))}
              </select>
            </label>
          </div>
          <div className="mb-4 w-1/4">
            <label className="input-group" htmlFor="CreditType">
              <span className="label-text">Credit Type</span>
              <select
                className="input input-bordered w-full"
                type="number"
                name="CreditType"
                data-type="integer"
                value="2"
                onChange={() => console.log("changedCreditNo")}
              >
                <option value=""></option>
                {credit.map((cred) => (
                  <option key={cred.AccountType} value={cred.AccountType}>
                    {cred.AccountDescription}
                  </option>
                ))}
              </select>
            </label>
          </div>
          <div className="mb-4 w-1/4">
            <label className="input-group" htmlFor="Date">
              <span className="label-text">Date</span>
              <input
                className="input input-bordered w-full"
                type="date"
                name="Date"
                data-type="datetime"
                defaultValue={
                  main.Date
                    ? main.Date.split("-").reverse().join("-")
                    : startDate
                }
              />
            </label>
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
                main.Date ? main.Date.split("-").reverse().join("-") : startDate
              }
            />
          </div> */}
        </div>
        <div className="flex space-x-20">
          <div className="mb-4 w-1/3">
            <label className="input-group" htmlFor="Type">
              <span className="label-text">Type</span>
              <select
                className="input input-bordered w-full"
                name="Type"
                data-type="integer"
                value={main.Type ? main.Type : ""}
                onChange={() => console.log("changedType")}
              >
                {invType.map((type) => (
                  <option key={type.TypeCode} value={type.TypeCode}>
                    {type.TypeDescription}
                  </option>
                ))}
              </select>
            </label>
          </div>
          <div className="mb-4 w-1/3">
            <label className="input-group" htmlFor="OrderNo">
              <span className="label-text">Order No</span>
              <input
                className="input input-bordered w-full"
                type="number"
                name="OrderNo"
                data-type="integer"
                defaultValue={main.OrderNo ? main.OrderNo : ""}
              />
            </label>
          </div>
          <div className="mb-4 w-1/3">
            <label className="input-group" htmlFor="Paid">
              <span className="label-text">Paid</span>
              <select
                className="input input-bordered w-full"
                name="Paid"
                data-type="boolean"
                defaultValue={main.Paid ? main.Paid : ""}
                onChange={() => console.log("changedPaid")}
              >
                <option value="false">No</option>
                <option value="true">Yes</option>
              </select>
            </label>
          </div>
        </div>

        <div className="flex space-x-10">
          <div className="mb-4 w-1/2">
            <label className="input-group" htmlFor="BusinessNo">
              <span className="label-text">Business</span>
              <select
                className="input input-bordered w-full"
                name="BusinessNo"
                data-type="integer"
                defaultValue={main.BusinessNo ? main.BusinessNo : ""}
                onChange={() => console.log("changedBusinessNo")}
              >
                <option value="0">G & R Morelli</option>
              </select>
            </label>
          </div>
          <div className="mb-4 w-1/2">
            <label className="input-group" htmlFor="PaymentDetail">
              <span className="label-text">Payment Detail</span>
              <input
                className="input input-bordered w-full"
                type="text"
                name="PaymentDetail"
                data-type="varchar"
                defaultValue={main.PaymentDetail ? main.PaymentDetail : ""}
              />
            </label>
          </div>
        </div>
        <div className="flex">
          <div className="mb-4 w-full">
            <label className="input-group" htmlFor="Note">
              <span className="label-text">Note</span>
              <input
                className="input input-bordered w-full"
                type="text"
                name="Note"
                data-type="varchar"
                defaultValue={main.Note ? main.Note : ""}
              />
            </label>
          </div>
        </div>
      </form>

      <InvoiceTransHeader
        transid={data.TransactionId}
        trans={trans}
        route={route}
      />
    </div>
  );
}

export default InvoiceForm;
