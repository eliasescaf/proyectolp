export const service = {
    load: function(id){
        return fetch(`client/load?id=${id}`) 
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
        return fetch("client/save", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(item)
        })
        .then(response => {return response.json()})
        .catch(error => {
            console.error("Error al guardar cliente");
            return {success: false, message: "Error al guardar cliente"};
        })
    },

    update: function(item){
        return fetch("client/update", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(item)
        })
        .then(response => {return response.json()})
        .catch(error => {
            console.error("Error al actualizar cliente");
            return {success: false, message: "Error al actualizar cliente"};
        })
    },

    delete: function(id){
        return fetch(`client/delete?id=${id}`)
        .then(response => {return response.json()})
        .catch(error => {
            console.error("Error al eliminar cliente");
            return {success: false, message: "Error al eliminar cliente"};
        })
    },

    list: function(params){
        const query = new URLSearchParams(params).toString();
        return fetch(`client/list?${query}`)
            .then(response => response.json())
            .catch(error => {
                console.error("Error al cargar cliente");
            })
    }

}