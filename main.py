import planta
import pymysql

if __name__ == "__main__":
    try:
	    conexion = pymysql.connect(host='localhost',user='root',password='')
	    with conexion.cursor() as cursor:
		    cursor.execute('CREATE DATABASE IF NOT EXISTS planta;')
		    cursor.execute('USE planta;')
		    cursor.execute('CREATE TABLE IF NOT EXISTS sensores(id_registro datetime PRIMARY KEY,nivelAgua double NOT NULL,turbidez INT NOT NULL,coagulante double NOT NULL,floculante double NOT NULL,cloro double NOT NULL);')
		    cursor.execute('CREATE TABLE IF NOT EXISTS reporteDiario(dia DATE PRIMARY KEY,cloro_gastado DOUBLE NOT NULL,coagulante_gastado DOUBLE NOT NULL,floculante_gastado DOUBLE NOT NULL,mid_tanque DOUBLE NOT NULL,max_tanque DOUBLE NOT NULL,min_tanque DOUBLE NOT NULL,mid_turbidez DOUBLE NOT NULL,max_turbidez DOUBLE NOT NULL,min_turbidez DOUBLE NOT NULL,cloro_bajaCantidad BOOLEAN NOT NULL,coagulante_bajaCantidad BOOLEAN NOT NULL,floculante_bajaCantidad BOOLEAN NOT NULL);')
		    planta.main()
    except (pymysql.err.OperationalError, pymysql.err.InternalError) as e:
	    print("Ocurrió un error al conectar: ", e)