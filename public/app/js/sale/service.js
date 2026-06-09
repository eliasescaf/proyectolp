const ventas = {
    1: {
        id: 1,
        fecha: "25/05/2026 14:32",
        usuario_nombre: "Elias Escalante Fuentes",
        total: 8000.00,
        detalles: [
            { planta_nombre: "Monstera Deliciosa", cantidad: 1, precio_unitario: 5500.00, subtotal: 5500.00 },
            { planta_nombre: "Lengua de Suegra", cantidad: 1, precio_unitario: 2500.00, subtotal: 2500.00 }
        ]
    }
};

export const service = {
    getById: function(id){
        return ventas[id];
    }
};