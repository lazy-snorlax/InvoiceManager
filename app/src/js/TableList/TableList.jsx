"use strict";

import React from "react";
import ReactDOMClient from "react-dom/client";

import Table from "./Table";

const dom = document.querySelector("#TableList");
const route = dom.dataset.invoiceroute;

const root = ReactDOMClient.createRoot(dom);
root.render(<Table route={route} />);
