INSERT INTO Administrador (nombre, apellido, correo, identificacion, clave)
VALUES(
    "Robinson",
    "Alza",
    "R.alza@PRONTOMUEBLE.com",
    "1234567890",
    md5("123")
),
(
    "Edward",
    "Castillo",
    "E.castillo@PRONTOMUEBLE.com",
    "9876543210",
    md5("123")
);