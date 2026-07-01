
export const service = {
    load: function(id){
        return fetch(`user/load?id=${id}`) 
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
    save: function(user){
        return fetch("user/save", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(user)
        })
        .then(response => {return response.json()})
        .catch(error => {
            console.error("Error al guardar usuario");
            return {success: false, message: "Error al guardar usuario"};
        })
    },
    update: function(user){
        return fetch("user/update", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(user)
        })
        .then(response => {return response.json()})
        .catch(error => {
            console.error("Error al actualizar usuario");
            return {success: false, message: "Error al actualizar usuario"};
        })
    },
    delete: function(id){
        return fetch(`user/delete?id=${id}`)
        .then(response => {return response.json()})
        .catch(error => {
            console.error("Error al eliminar usuario");
            return {success: false, message: "Error al eliminar usuario"};
        })
    },

    list: function(params) {
        const query = new URLSearchParams(params).toString();
        return fetch(`user/list?${query}`)
            .then(response => response.json())
            .catch(error => {
                console.error("Error al cargar usuario");
            })
    },

    
}