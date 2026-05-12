const users = [
    {id: 1, nombre:"Elias Escalante Fuentes", cuenta:"eliasss10", perfil:"operador", correo:"eliasescalante27@gmail.com", contraseña:"jorge1234", fechaAlta: "2026-01-15", estado: "Activo"},
    {id: 2, nombre:"Edinson Cavani", cuenta:"matador", perfil:"admin", correo:"cavani@boca.com.ar", contraseña:"pass", fechaAlta: "2026-02-10", estado: "Activo"},
    {id: 3, nombre:"Kevin Zenón", cuenta:"zenon22", perfil:"operador", correo:"kevin@boca.com.ar", contraseña:"pass", fechaAlta: "2026-02-12", estado: "Activo"},
    {id: 4, nombre:"Adam Bareiro", cuenta:"zorrito13", perfil:"operador", correo:"bareiro@boca.com.ar", contraseña:"pass", fechaAlta: "2026-02-15", estado: "Activo"},
    {id: 5, nombre:"Lautaro Di Lollo", cuenta:"eldosss", perfil:"admin", correo:"dilollo@boca.com.ar", contraseña:"pass", fechaAlta: "2026-03-01", estado: "Activo"},
    {id: 6, nombre:"Miguel Merentiel", cuenta:"bestia", perfil:"operador", correo:"miguel@boca.com.ar", contraseña:"pass", fechaAlta: "2026-03-05", estado: "Activo"},
    {id: 7, nombre:"Milton Delgado", cuenta:"chelito12", perfil:"admin", correo:"chelo@boca.com.ar", contraseña:"pass", fechaAlta: "2026-03-10", estado: "Inactivo"},
    {id: 8, nombre:"Ezequiel Fernández", cuenta:"equi", perfil:"operador", correo:"equi@boca.com.ar", contraseña:"pass", fechaAlta: "2026-03-12", estado: "Activo"},
    {id: 9, nombre:"Leandro Paredes", cuenta:"capitan5", perfil:"operador", correo:"capi@boca.com.ar", contraseña:"pass", fechaAlta: "2026-03-15", estado: "Activo"},
    {id: 10, nombre:"Paulo Dybala", cuenta:"joya21", perfil:"admin", correo:"paulito@boca.com.ar", contraseña:"pass", fechaAlta: "2026-03-20", estado: "Inactivo"},
    {id: 11, nombre:"Exequiel Zeballos", cuenta:"changooo", perfil:"operador", correo:"chango@boca.com.ar", contraseña:"pass", fechaAlta: "2026-03-25", estado: "Activo"},
    {id: 12, nombre:"Dylan Gorosito", cuenta:"el4desiempre", perfil:"operador", correo:"goro@boca.com.ar", contraseña:"pass", fechaAlta: "2026-04-01", estado: "Activo"}
];

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
        user.id = users.length + 1;
        users.push(user);
    },
    update: function(user){
        for(let i = 0; i < users.length; i++){
            if(users[i].id == user.id){
                user.fechaAlta = users[i].fechaAlta;
                if(!user.estado) {
                    user.estado = users[i].estado;
                }
                users[i] = user;
                return true;
            }
        }
        return false;
    },
    delete: function(id){
        for(let i = 0; i < users.length; i++){
            if(users[i].id == id){
                users.splice(i, 1);
                return true;
            }
        }
        return false;
    },
    list: function(){
        return users;
    }
}