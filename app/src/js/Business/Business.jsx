"use strict";

import React from "react";
import ReactDOMClient from "react-dom/client";
import BusinessForm from "./BusinessForm";
// import InvoiceForm from "./InvoiceForm";

const dom = document.querySelector("#BusinessDetails");
const route = dom.dataset.route;
const data = dom.dataset.d;
// const trans = dom.dataset.trans;

const root = ReactDOMClient.createRoot(dom);
root.render(<BusinessForm data={JSON.parse(data)} route={route} />);
