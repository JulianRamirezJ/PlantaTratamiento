import pymysql
try:
	conexion = pymysql.connect(host='localhost',user='root',password='',db='planta')
	with conexion.cursor() as cursor:
			cursor.execute("DELETE FROM sensores;")
			cursor.execute("DELETE FROM reportediario;")
except (pymysql.err.OperationalError, pymysql.err.InternalError) as e:
	    print("Ocurrió un error al conectar: ", e)