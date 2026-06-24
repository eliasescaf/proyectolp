import { controller } from "./controller.js";

document.addEventListener("DOMContentLoaded", () => {
    window.controller = controller;
    controller.init(); 
});