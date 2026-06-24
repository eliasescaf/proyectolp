
export const service = {
    load: function(id){
        return fetch(`sale/load?id=${id}`) 
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.json();
            })
            .then(result => {
                return result.success ? result.data : false;
            })
            .catch(error => {
                console.error("Error real en el fetch de load:", error.message);
                return false;
            });
    },
    save: function(sale){
        return fetch("sale/save", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(sale)
        })
        .then(response => {return response.json()})
        .catch(error => {
            console.error("Error al guardar venta");
            return {success: false, message: "Error al guardar venta"};
        })
    },

    list: function(params = { page: 1, limit: 10 }) {
        return fetch(`sale/list?page=${params.page}&limit=${params.limit}`)
            .then(response => response.json())
            .catch(error => {
                console.error("Error al cargar venta");
            })
    },

    getProductSuggestions: function(cadena){
        return fetch(`item/suggestive?valueToSearch=${encodeURIComponent(cadena)}`)
            .then(response => {
                if (!response.ok) throw new Error("Error en el servidor");
                return response.json();
            })
            .catch(error => {
                console.error("Error al traer sugerencias de ítems:", error);
                return { success: false, data: { records: [] } };
            });
    },

    getClientSuggestions: function(cadena){
        return fetch(`client/suggestive?valueToSearch=${encodeURIComponent(cadena)}`)
            .then(response => {
                if (!response.ok) throw new Error("Error en el servidor");
                return response.json();
            })
            .catch(error => {
                console.error("Error al traer sugerencias de clientes:", error);
                return { success: false, data: { records: [] } };
            });
    }

    
}