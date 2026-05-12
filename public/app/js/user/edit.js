import { controller } from "./controller.js";

document.addEventListener("DOMContentLoaded", () => {
    window.controller = controller;
    
    const params = new URLSearchParams(window.location.search);
    const id = params.get("id");
    
    if (id) {
        controller.load(id);
    }
    controller.bindEvents(); 
});