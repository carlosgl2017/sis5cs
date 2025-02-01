ALTER TABLE reporte_buro
ADD COLUMN id_credito INTEGER;
ALTER TABLE reporte_buro
ADD COLUMN marcabaja int DEFAULT 1;

ALTER TABLE deposito_bancario
ADD COLUMN id_credito INTEGER;
ALTER TABLE deposito_bancario
ADD COLUMN marcabaja int DEFAULT 1;

ALTER TABLE inversiones_financieras
ADD COLUMN id_credito INTEGER;
ALTER TABLE inversiones_financieras
ADD COLUMN marcabaja int DEFAULT 1;


ALTER TABLE cuentas_documentos_cobrar
ADD COLUMN id_credito INTEGER;
ALTER TABLE cuentas_documentos_cobrar
ADD COLUMN marcabaja int DEFAULT 1;

ALTER TABLE inventario_mercaderia
ADD COLUMN id_credito INTEGER;
ALTER TABLE inventario_mercaderia
ADD COLUMN marcabaja int DEFAULT 1;

ALTER TABLE maquinaria_equipo
ADD COLUMN id_credito INTEGER;
ALTER TABLE maquinaria_equipo
ADD COLUMN marcabaja int DEFAULT 1;

ALTER TABLE bienes_hogar
ADD COLUMN id_credito INTEGER;
ALTER TABLE bienes_hogar
ADD COLUMN marcabaja int DEFAULT 1;

ALTER TABLE inmueble
ADD COLUMN id_credito INTEGER;
ALTER TABLE inmueble
ADD COLUMN marcabaja int DEFAULT 1;

ALTER TABLE vehiculo
ADD COLUMN id_credito INTEGER;
ALTER TABLE vehiculo
ADD COLUMN marcabaja int DEFAULT 1;

ALTER TABLE efectivos_caja
ADD COLUMN id_credito INTEGER;
ALTER TABLE efectivos_caja
ADD COLUMN marcabaja int DEFAULT 1;

ALTER TABLE otros_activos
ADD COLUMN id_credito INTEGER;
ALTER TABLE otros_activos
ADD COLUMN marcabaja int DEFAULT 1;

ALTER TABLE prestamo_bancario
ADD COLUMN id_credito INTEGER;
ALTER TABLE prestamo_bancario
ADD COLUMN marcabaja int DEFAULT 1;

ALTER TABLE cuentas_por_pagar
ADD COLUMN id_credito INTEGER;
ALTER TABLE cuentas_por_pagar
ADD COLUMN marcabaja int DEFAULT 1;

ALTER TABLE gastos_familiares
ADD COLUMN id_credito INTEGER;
ALTER TABLE gastos_familiares
ADD COLUMN marcabaja int DEFAULT 1;

ALTER TABLE gastos_operativos_comercializacion
ADD COLUMN id_credito INTEGER;
ALTER TABLE gastos_operativos_comercializacion
ADD COLUMN marcabaja int DEFAULT 1;

ALTER TABLE mano_obra_mensual
ADD COLUMN id_credito INTEGER;
ALTER TABLE mano_obra_mensual
ADD COLUMN marcabaja int DEFAULT 1;

ALTER TABLE ingreso_mensual
ADD COLUMN id_credito INTEGER;
ALTER TABLE ingreso_mensual
ADD COLUMN marcabaja int DEFAULT 1;

ALTER TABLE venta_comercializacion_productos
ADD COLUMN id_credito INTEGER;
ALTER TABLE venta_comercializacion_productos
ADD COLUMN marcabaja int DEFAULT 1;

ALTER TABLE capacidad_pago
ADD COLUMN id_credito INTEGER;
ALTER TABLE capacidad_pago
ADD COLUMN marcabaja int DEFAULT 1;

ALTER TABLE croquis
ADD COLUMN id_credito INTEGER;
ALTER TABLE croquis
ADD COLUMN marcabaja int DEFAULT 1;

CREATE TABLE tipo_solicitud (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    marcabaja int DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE credito
ADD COLUMN id_solicitud integer;

ALTER TABLE credito
ADD CONSTRAINT fk_id_solicitud
FOREIGN KEY (id_solicitud) REFERENCES tipo_solicitud (id)

INSERT INTO tipo_solicitud (nombre) VALUES ('SOLICITUD NUEVO PRESTAMO');
INSERT INTO tipo_solicitud (nombre) VALUES ('SOLICITUD DE REFINANCIAMIENTO');
INSERT INTO tipo_solicitud (nombre) VALUES ('SOLICITUD DE REPROGRAMACION');

ALTER TABLE codeudor
ADD COLUMN id_credito INTEGER;
ALTER TABLE codeudor
ADD COLUMN marcabaja int DEFAULT 1;

ALTER TABLE ventas
ADD COLUMN id_credito INTEGER;
ALTER TABLE ventas
ADD COLUMN marcabaja int DEFAULT 1;

ALTER TABLE credito
ADD COLUMN fecha_reprogramacion DATE;
ALTER TABLE credito
ADD COLUMN marcabaja int DEFAULT 1;
ALTER TABLE credito
ADD COLUMN id_operacion_anterior INTEGER;


CREATE TABLE reprogramados (
    id SERIAL PRIMARY KEY,           -- Clave primaria autoincremental
    id_credito integer NOT NULL,    -- Nombre de la categoría
    id_credito_rep integer NOT NULL,    -- Nombre de la categoría
    id_persona integer NOT NULL,    -- Nombre de la categoría
    id_usuario integer NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Fecha/Hora de creación
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Fecha/Hora de actualización
    FOREIGN KEY (id_credito) REFERENCES credito (id_credito)
);

