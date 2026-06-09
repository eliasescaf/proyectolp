let items = JSON.parse(localStorage.getItem("plantas_db")) || [
    { id: 1, nombre: "Lazo de Amor", codigo: "LAZ-01", riego: "2", descripcion: "Planta colgante muy resistente, ideal para principiantes.", categoria: "1", precio: 1200, stock: 15, estado: "Activo", fechaAlta: "2026-01-10" },
    { id: 2, nombre: "Lengua de Suegra", codigo: "LEN-02", riego: "1", descripcion: "Purifica el aire y requiere muy poca luz.", categoria: "1", precio: 2500, stock: 8, estado: "Activo", fechaAlta: "2026-01-15" },
    { id: 3, nombre: "Lavanda", codigo: "LAV-01", riego: "1", descripcion: "Planta aromática que requiere sol directo y poco riego.", categoria: "2", precio: 950, stock: 20, estado: "Activo", fechaAlta: "2026-02-01" },
    { id: 4, nombre: "Monstera Deliciosa", codigo: "MON-01", riego: "2", descripcion: "Hojas grandes perforadas, tendencia en decoración.", categoria: "1", precio: 5500, stock: 3, estado: "Activo", fechaAlta: "2026-02-05" },
    { id: 5, nombre: "Aloe Vera", codigo: "ALOE-01", riego: "1", descripcion: "Suculenta con propiedades medicinales para la piel.", categoria: "3", precio: 1100, stock: 30, estado: "Activo", fechaAlta: "2026-02-10" },
    { id: 6, nombre: "Helecho Serrucho", codigo: "HEL-01", riego: "3", descripcion: "Necesita mucha humedad ambiental y sombra.", categoria: "1", precio: 1800, stock: 10, estado: "Activo", fechaAlta: "2026-02-15" },
    { id: 7, nombre: "Palo de Agua", codigo: "PAL-01", riego: "2", descripcion: "Tronco ornamental que aporta verticalidad.", categoria: "1", precio: 3800, stock: 5, estado: "Activo", fechaAlta: "2026-03-01" },
    { id: 8, nombre: "Rosal Enano", codigo: "ROS-01", riego: "3", descripcion: "Flores constantes si se mantiene al sol.", categoria: "2", precio: 2200, stock: 12, estado: "Activo", fechaAlta: "2026-03-05" },
    { id: 9, nombre: "Cactus de Navidad", codigo: "CAC-01", riego: "1", descripcion: "Florece en invierno con colores vibrantes.", categoria: "3", precio: 1300, stock: 7, estado: "Activo", fechaAlta: "2026-03-10" },
    { id: 10, nombre: "Hortensia", codigo: "HOR-01",riego: "3", descripcion: "Requiere suelo ácido y mucha agua en verano.", categoria: "2", precio: 2800, stock: 4, estado: "Activo", fechaAlta: "2026-03-20" },
    { id: 11, nombre: "Potos", codigo: "POT-01",riego: "2", descripcion: "Planta trepadora o colgante de rápido crecimiento.", categoria: "1", precio: 1400, stock: 18, estado: "Activo", fechaAlta: "2026-04-01" },
    { id: 12, nombre: "Jazmín del Cabo", codigo: "JAZ-01",riego: "3", descripcion: "Arbusto de flores blancas con aroma intenso.", categoria: "2", precio: 3200, stock: 0, estado: "Inactivo", fechaAlta: "2026-04-10" }
];

const saveToLocalStorage = () => {
    localStorage.setItem("plantas_db", JSON.stringify(items))
};

export const service = {
    load: function(id){
        for(let i = 0; i < items.length; i++){
            if(items[i].id == id){
                return items[i];
            }
        }
        return null;
    },

    save: function(item){
        const maxId = items.length > 0 ? Math.max(...items.map(i => i.id)) : 0;
        item.id = maxId + 1;

        item.estado = "Activo"
        item.fechaAlta = new Date().toLocaleDateString();

        items.push(item);
        saveToLocalStorage();

        return true;
    },

    saveRemote: function(data) {
        return fetch('item/save', {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (response.ok) return response.json();
            throw new Error("Error en el pipeline del servidor: " + response.status);
        });
    },

    update: function(item){
        for(let i = 0; i < items.length; i++){
            if(items[i].id == item.id){
                item.fechaAlta = items[i].fechaAlta;
                if(!item.estado){
                    item.estado = items[i].estado;
                }
                items[i] = item;
                saveToLocalStorage();
                return true;
            };
        };
        return false;
    },

    delete: function(id){
        for(let i = 0; i < items.length; i++){
            if(items[i].id == id){
                items.splice(i, 1);
                saveToLocalStorage();
                return true;
            };
        };
        return false;
    },

    list: function(){
        return items;
    }

}