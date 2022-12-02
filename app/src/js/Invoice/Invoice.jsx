"use strict";

import React from "react";
import ReactDOMClient from "react-dom/client";

const dom = document.querySelector("#invoiceDetails");
const route = dom.dataset.invoiceroute;

const root = ReactDOMClient.createRoot(dom);
