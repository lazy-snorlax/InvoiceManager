"use strict";
import React from "react";

function MenuList() {
  return (
    <div className="card shadow-md side bg-neutral">
      <div className="flex-row items-center card-body">
        <a className="btn btn-wide">Invoices</a>
        <a className="btn btn-wide">Quotes</a>
        <a className="btn btn-wide">Customers</a>
        <a className="btn btn-wide">Suppliers</a>
        <a className="btn btn-wide">Business</a>
        <a className="btn btn-wide">Settings</a>
        <a className="btn btn-wide">Reports</a>
      </div>
    </div>
  );
}

export default MenuList;
