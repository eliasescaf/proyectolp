let users = JSON.parse(localStorage.getItem("usuarios_db")) || [
    {id: 1, nombre:"Elias Escalante Fuentes", cuenta:"eliasss10", perfil:"1", correo:"eliasescalante27@gmail.com", contraseña:"jorge1234", fechaAlta: "2026-01-15", estado: "Activo"},
    {id: 2, nombre:"Edinson Cavani", cuenta:"matador", perfil:"2", correo:"cavani@boca.com.ar", contraseña:"pass", fechaAlta: "2026-02-10", estado: "Activo"},
    {id: 3, nombre:"Kevin Zenón", cuenta:"zenon22", perfil:"1", correo:"kevin@boca.com.ar", contraseña:"pass", fechaAlta: "2026-02-12", estado: "Activo"},
    {id: 4, nombre:"Adam Bareiro", cuenta:"zorrito13", perfil:"1", correo:"bareiro@boca.com.ar", contraseña:"pass", fechaAlta: "2026-02-15", estado: "Activo"},
    {id: 5, nombre:"Lautaro Di Lollo", cuenta:"eldosss", perfil:"2", correo:"dilollo@boca.com.ar", contraseña:"pass", fechaAlta: "2026-03-01", estado: "Activo"},
    {id: 6, nombre:"Miguel Merentiel", cuenta:"bestia", perfil:"1", correo:"miguel@boca.com.ar", contraseña:"pass", fechaAlta: "2026-03-05", estado: "Activo"},
    {id: 7, nombre:"Milton Delgado", cuenta:"chelito12", perfil:"2", correo:"chelo@boca.com.ar", contraseña:"pass", fechaAlta: "2026-03-10", estado: "Inactivo"},
    {id: 8, nombre:"Ezequiel Fernández", cuenta:"equi", perfil:"1", correo:"equi@boca.com.ar", contraseña:"pass", fechaAlta: "2026-03-12", estado: "Activo"},
    {id: 9, nombre:"Leandro Paredes", cuenta:"capitan5", perfil:"1", correo:"capi@boca.com.ar", contraseña:"pass", fechaAlta: "2026-03-15", estado: "Activo"},
    {id: 10, nombre:"Paulo Dybala", cuenta:"joya21", perfil:"2", correo:"paulito@boca.com.ar", contraseña:"pass", fechaAlta: "2026-03-20", estado: "Inactivo"},
    {id: 11, nombre:"Exequiel Zeballos", cuenta:"changooo", perfil:"1", correo:"chango@boca.com.ar", contraseña:"pass", fechaAlta: "2026-03-25", estado: "Activo"},
    {id: 12, nombre:"Dylan Gorosito", cuenta:"el4desiempre", perfil:"1", correo:"goro@boca.com.ar", contraseña:"pass", fechaAlta: "2026-04-01", estado: "Activo"}
];

const saveToLocalStorage = () =>{
    localStorage.setItem("usuarios_db", JSON.stringify(users));
};

export const service = {
    load: function(id){
        for(let i = 0; i < users.length; i++){
            if(users[i].id == id){
                return users[i];
            }
        }
        return null;
    },
    save: function(user){
        const maxId = users.length > 0 ? Math.max(...users.map(u => u.id)) : 0;
        user.id = maxId + 1;
    
        user.estado = "Activo";
        user.fechaAlta = new Date().toLocaleDateString();

        users.push(user);
        saveToLocalStorage();
        return true;
    },
    update: function(user){
        for(let i = 0; i < users.length; i++){
            if(users[i].id == user.id){
                user.fechaAlta = users[i].fechaAlta;
                if(!user.estado) {
                    user.estado = users[i].estado;
                }
                users[i] = user;
                saveToLocalStorage();
                return true;
            }
        }
        return false;
    },
    delete: function(id){
        for(let i = 0; i < users.length; i++){
            if(users[i].id == id){
                users.splice(i, 1);
                saveToLocalStorage();
                return true;
            }
        }
        return false;
    },
    list: function(){
        return users;
    }
}