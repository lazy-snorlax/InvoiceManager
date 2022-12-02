"use strict";

import React from "react";
import ReactDOMClient from "react-dom/client";
import InvoiceForm from "./InvoiceForm";

const dom = document.querySelector("#invoiceDetails");
const route = dom.dataset.route;
const data = dom.dataset.d;

const root = ReactDOMClient.createRoot(dom);
root.render(<InvoiceForm route={JSON.parse(route)} data={JSON.parse(data)} />);
