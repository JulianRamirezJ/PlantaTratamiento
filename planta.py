#Previo a ejecutar el programa debe verificar que tenga instaladas las siguientes cosas:
# - Interprete de python(Preferiblemente 3.7 o superior),además debe estar agregado en el path
# - Servidor local ( Xampp, Wampp ,....)
# - PyMySQL: pip install pymsql
# - ReportLab: pip install reportlab
# - Libreria para comunicarse con IoT: pip install requests
import time
import random
import time
import pymysql # pip install PyMySQL
import datetime
from datetime import date, time, datetime
import generarInforme
import enviarDatosIoT


def main():
    nivelTanque = 200000 #L
    turbidez = 250 #NTU
    coagulante= 10 #kg
    floculante = 8 #kg
    cloro = 20 #L
    coagulante_litro = 1.2 * 0.000025 #Coagulante por 1.2 litros de agua
    floculante_litro = 1.2 *  0.000015 #Fliculante por 1.2 litros de agua
    cloro_litro = 1.2 * 0.00005 #Cloro por 1.2 litros de agua
    aguaDemanda = 0.2 #Agua que se demanda por segundo
    activarPlanta = False
    modoLimite = False

    coagulante_diario = 0
    floculante_diario = 0
    cloro_diario = 0

    min_tanque = 200000
    max_tanque = 0
    mid_tanque = 0
    min_turbidez = 200000
    max_turbidez = 0
    mid_turbidez = 0
    modoLimite = False
    for i in range(1,16,1):#Ciclo de los dias(15 dias)
        mes = int(time.strftime("%m"))
        dia = int(time.strftime("%d"))
        #horas = 0
        #minutos = 0
        coagulante_diario = 0
        floculante_diario = 0
        cloro_diario = 0
        min_tanque = 200000
        max_tanque = 0
        mid_tanque = 0
        min_turbidez = 200000
        max_turbidez = 0
        mid_turbidez = 0
        for j in range(0,24,1):#Ciclo de las horas(24 horas)
            if modoLimite == False:
                aguaDemanda = random.uniform(0.2,2.0)
            else:
                aguaDemanda = random.uniform(0.2,0.6)
            mid_tanque_hora = 0
            mid_turbidez_hora = 0
            for k in range(0,60,1):#Ciclo de los minutos(60 minutos)

                if nivelTanque < 30000:#Tanque a menos del 15%
                    aguaDemanda = random.uniform(0.2,0.6)
                    modoLimite = True
                if modoLimite == True and nivelTanque > 120000:
                    modoLimite = False

                nivelTanque -= aguaDemanda * 60
                    
                if nivelTanque < 140000 and activarPlanta == False: #Tanque a menos del 70% de la capacidad
                    activarPlanta = True
                    
                if activarPlanta == True:
                    if nivelTanque > 190000:#Tanque a mas del 95%
                        activarPlanta = False
                    else:
                        nivelTanque += 1.2*60
                        coagulante -= coagulante_litro * 60
                        floculante -= floculante_litro * 60
                        cloro -= cloro_litro * 60
                        coagulante_diario += coagulante_litro * 60
                        floculante_diario += floculante_litro * 60
                        cloro_diario -= cloro_litro * 60
                    
                if (k % 10) == 0 or k==0:#Se cambia el valor de la turbidez cada 10 minutos
                    turbidez = random.randint(250,800)

                min_tanque = min(min_tanque, nivelTanque)
                max_tanque = max(max_tanque, nivelTanque)
                mid_tanque += nivelTanque
                min_turbidez = min(min_turbidez, turbidez)
                max_turbidez = max(max_turbidez, turbidez)
                mid_turbidez += turbidez
                mid_tanque_hora += nivelTanque
                mid_turbidez_hora += turbidez
                
                t = str(dia)+'-'+str(mes)+'-'+str(2021)+' '+str(j)+':'+str(k)+':'+str(0)
                tiempo = datetime.strptime(t, '%d-%m-%Y %H:%M:%S')
                insertarDatosBD(nivelTanque,turbidez,cloro,coagulante,floculante,tiempo)
                time.sleep(0.3)#Pasa un minuto
            
            cargarDatosIoT(mid_tanque_hora/60,mid_turbidez_hora/60,cloro,coagulante,floculante)

        cloro_bajaCantidad = False
        coagulante_bajaCantidad = False
        floculante_bajaCantidad = False
        if cloro < (cloro_diario*1.5):
            cloro = 20 #L
            cloro_bajaCantidad = True
        if coagulante < (coagulante_diario*1.5):
            coagulante = 10 #Kg
            coagulante_bajaCantidad = True
        if floculante < (floculante_diario * 1.5):
            floculante = 8 #Kg
            floculante_bajaCantidad = True
        f = str(dia)+'-'+str(mes)+'-'+str(2021)
        fecha2 = datetime.strptime(f, '%d-%m-%Y')
        fecha = str(fecha2).split(' ')[0]
        informeDiario(min_tanque,max_tanque,mid_tanque/1440,min_turbidez,max_turbidez,mid_turbidez/1440,
                     cloro_diario,coagulante_diario,floculante_diario,cloro_bajaCantidad,
                     coagulante_bajaCantidad,floculante_bajaCantidad,fecha)#1440 n° de minutos en 24 horas
        if dia == 30:
            dia = 1
            mes+=1
        else:
            dia += 1
            
                

def cargarDatosIoT(mid_tanque_hora,mid_turbidez_hora,cloro,coagulante,floculante):
    print("Datos actualizados en la plataforma IoT")
    enviarDatosIoT.enviarDatos(mid_tanque_hora,mid_turbidez_hora,coagulante,floculante,cloro)

def informeDiario(min_tanque,max_tanque,mid_tanque,min_turbidez,max_turbidez,mid_turbidez,
                    cloro_diario,coagulante_diario,floculante_diario,cloro_bajaCantidad,
                    coagulante_bajaCantidad,floculante_bajaCantidad,fecha):
    print ("Informe diario : ",end="")
    print(fecha)
    print(str(min_tanque)+"-"+str(max_tanque)+"-"+str(mid_tanque)+"--"+str(min_turbidez)+"-"+str(max_turbidez)+"-"+str(mid_turbidez)
    +"--"+str(cloro_diario)+"-"+str(coagulante_diario)+"-"+str(floculante_diario))
    try:
	    conexion = pymysql.connect(host='localhost',user='root',password='',db='planta')
	    try:
		    with conexion.cursor() as cursor:
			    consulta = "INSERT INTO  reportediario VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s);"
            
			    cursor.execute(consulta, (fecha, cloro_diario, coagulante_diario, floculante_diario, mid_tanque,
                                 max_tanque,min_tanque, mid_turbidez, max_turbidez, min_turbidez,cloro_bajaCantidad,
                                 coagulante_bajaCantidad,floculante_bajaCantidad))
		    conexion.commit()
	    finally:
		    conexion.close()
    except (pymysql.err.OperationalError, pymysql.err.InternalError) as e:
	    print("Ocurrió un error al conectar: ", e)
    generarInforme.generarDocumento()


def insertarDatosBD(nivelTanque, turbidez,cloro,coagulante,floculante,tiempo):
    print(tiempo)
    try:
	    conexion = pymysql.connect(host='localhost',user='root',password='',db='planta')
	    try:
		    with conexion.cursor() as cursor:
			    consulta = "INSERT INTO sensores(id_registro,nivelAgua,turbidez,coagulante,floculante,cloro) VALUES (%s, %s, %s, %s, %s, %s);"
			    cursor.execute(consulta, (tiempo, nivelTanque, turbidez, coagulante, floculante, cloro))
		    conexion.commit()
	    finally:
		    conexion.close()
	
    except (pymysql.err.OperationalError, pymysql.err.InternalError) as e:
	    print("Ocurrió un error al conectar: ", e)
        

if __name__ == "__main__":
    main()