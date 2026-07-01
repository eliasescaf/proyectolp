export const service = {
    load: function(id){
        return fetch(`item/load?id=${id}`) 
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

    save: function(item){
        return fetch("item/save", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(item)
        })
        .then(response => {return response.json()})
        .catch(error => {
            console.error("Error al guardar producto");
            return {success: false, message: "Error al guardar producto"};
        })
    },

    update: function(item){
        return fetch("item/update", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(item)
        })
        .then(response => {return response.json()})
        .catch(error => {
            console.error("Error al actualizar producto");
            return {success: false, message: "Error al actualizar producto"};
        })
    },

    delete: function(id){
        return fetch(`item/delete?id=${id}`)
        .then(response => {return response.json()})
        .catch(error => {
            console.error("Error al eliminar producto");
            return {success: false, message: "Error al eliminar producto"};
        })
    },

    list: function(params){
        const query = new URLSearchParams(params).toString();

        return fetch(`item/list?${query}`)
            .then(response => response.json())
            .catch(error => {
                console.error("Error al cargar producto");
            })
    }

}