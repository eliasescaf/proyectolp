import { controller } from "./controller.js";

document.addEventListener("DOMContentLoaded", () => {
    window.controller = controller;
    
    const params = new URLSearchParams(window.location.search);
    const id = params.get("id");
    
    if (id) {
        controller.load(id);
    }
     else {
        console.error("No se encontró un ID en la URL");
    }
    controller.bindEvents(); 
});