import pymysql
from pymysql.cursors import DictCursor
from reportlab.lib import styles
import math
#Librerias reportlab a usar:
from reportlab.platypus import (SimpleDocTemplate, PageBreak, Image, Spacer,
Paragraph, Table, TableStyle)
from reportlab.lib.styles import getSampleStyleSheet
from reportlab.lib.pagesizes import A4
from reportlab.lib import colors
from reportlab.platypus.doctemplate import onDrawStr
from reportlab.platypus.flowables import DocExec

def obtenerLista():
    lista = []
    lista1 = []
    lista2 = []
    lista3 = []
    lista4 = []
    datos = []
    try:
	    conexion = pymysql.connect(host='localhost',user='root',password='',db='planta')
	    try:
		    with conexion.cursor() as cursor:
			    consulta = "SELECT * FROM reportediario ORDER BY dia DESC LIMIT 4;"
			    cursor.execute(consulta)
			    datos1 = cursor.fetchall()
			    len_datos = len(datos1)
			    datos = list(datos1)
			    if len_datos == 1:
				    lista2 = ['-'] * 13
				    lista3 = ['-'] * 13
				    lista4 = ['-'] * 13
				    datos.append(lista2)
				    datos.append(lista3)
				    datos.append(lista4)
			    elif len_datos == 2:
				    lista3 = ['-'] * 13
				    lista4 = ['-'] * 13
				    datos.append(lista3)
				    datos.append(lista4)
			    elif len_datos == 3:
				    lista4 = ['-'] * 13
				    datos.append(lista4)
	    finally:
		    conexion.close()
    except (pymysql.err.OperationalError, pymysql.err.InternalError) as e:
	    print("Ocurrió un error al conectar: ", e)
    return datos

def costo(lista,i,j):
    if lista[i][j] == '-':
        return '-'
    else:
        return '$'+str(round(lista[i][j]*10000,2))

def disponibilidad(lista,i,j):
    if lista[i][j] == 1:
        return 'Baja cantidad'
    else:
        return 'Suficiente cantidad'

def generarDocumento():
    lista = obtenerLista()
    doc = SimpleDocTemplate("reportes/"+str(lista[0][0]), pagesize = A4)
    story=[]
    texto1 = Paragraph(''' Informe diario  :   2021-05-04  ''')
    story.append(Spacer(0, 50))
    story.append(texto1)
    story.append(Spacer(0, 30))
    texto2 = Paragraph('''Existencias de Quimicos:''')  
    story.append(texto2)
    story.append(Spacer(0, 5))
    listaQuimicos = obtenerLista()
    t=Table(
        data=[
            ['','','Actual:'+str(lista[0][0]), lista[1][0], lista[2][0], lista[3][0]],
            ['\nCoagulante', 'Gasto', str(round(lista[0][2],2))+'kg', str(round(lista[1][2],2))+'kg', str(round(lista[2][2],2))+'kg',str(round(lista[3][2],2))+'kg'],
            ['', 'Costo', costo(lista,0,2), costo(lista,1,2), costo(lista,2,2),costo(lista,3,2)],
            ['\nFloculante', 'Gasto', str(round(lista[0][3],2))+'kg', str(round(lista[1][3],2))+'kg', str(round(lista[2][3],2))+'kg', str(round(lista[3][3],2))+'kg'],
            ['', 'Costo', costo(lista,0,3), costo(lista,1,3), costo(lista,2,3),costo(lista,3,3)],
            ['\nCloro', 'Gasto', str(round(lista[0][1],2))+'L', str(round(lista[1][1],2))+'L', str(round(lista[2][1],2))+'L',str(round(lista[3][1],2))+'L'],
            ['', 'Costo', costo(lista,0,1), costo(lista,1,1), costo(lista,2,1),costo(lista,3,1)],
        ],
        style=[
            ('GRID',(0,0),(-1,-1),0.5,colors.grey),
            ('BACKGROUND',(0,0),(6,0),colors.grey),
            ('BACKGROUND',(0,1),(0,2),colors.palegreen),
            ('BACKGROUND',(0,3),(0,4), colors.pink),
            ('BACKGROUND',(0,5),(0,6), colors.paleturquoise),
            ('SPAN',(0,0),(1,0)),
             ('SPAN',(0,1),(0,2)),
            ('SPAN',(0,3),(0,4)),
            ('SPAN',(0,5),(0,6))
        ])
    story.append(Spacer(0, 10))
    story.append(t)
    story.append(Spacer(0, 40))
    texto2 = Paragraph('''Niveles del tanque:''')
    story.append(texto2)
    story.append(Spacer(0, 10))
    t2=Table(
        data=[
         ['','Actual:'+str(lista[0][0]),lista[1][0], lista[2][0], lista[3][0]],
            ['Maximo', str(lista[0][4])+'L', str(lista[1][4])+'L', str(lista[2][4])+'L', str(lista[3][4])+'L'],
         ['Minimo', str(lista[0][6])+'L', str(lista[1][6])+'L', str(lista[2][6])+'L', str(lista[3][6])+'L'],
            ['Medio', str(lista[0][4])+'L', str(lista[1][4])+'L', str(lista[2][4])+'L', str(lista[3][4])+'L']
     ],
        style=[
        ('GRID',(0,0),(-1,-1),0.5,colors.grey),
        ('BACKGROUND',(0,0),(6,0),colors.grey),
        ])
    story.append(t2)
    story.append(Spacer(0, 40))

    texto3 = Paragraph('''Niveles de turbidez:''')
    story.append(texto3)
    story.append(Spacer(0, 10))
    t3=Table(
        data=[
         ['','Actual','2021-02', '2021-01', '2021-00'],
            ['Maximo', str(lista[0][8])+'NTU', str(lista[1][8])+'NTU', str(lista[2][8])+'NTU', str(lista[3][8])+'NTU'],
            ['Minimo', str(lista[0][9])+'NTU', str(lista[1][9])+'NTU', str(lista[2][9])+'NTU', str(lista[3][9])+'NTU'],
            ['Medio', str(lista[0][7])+'NTU', str(lista[1][7])+'NTU', str(lista[2][7])+'NTU', str(lista[3][7])+'NTU']
        ],
        style=[
            ('GRID',(0,0),(-1,-1),0.5,colors.grey),
         ('BACKGROUND',(0,0),(6,0),colors.grey),
        ])
    story.append(t3)
    if lista[0][8] > 780:
            story.append(Spacer(0, 5))
            texto6 = Paragraph('''Alerta: Niveles superiores a 780 NTU''')
            story.append(texto6)

    story.append(Spacer(0, 40))

    texto4 = Paragraph('''Disponibilidad de quimicos:''')
    story.append(texto4)
    story.append(Spacer(0, 10))
    t4=Table(
        data=[
            ['','Disponibilidad' ],
            ['Coagulante', disponibilidad(lista,0,11)],
            ['Floculante', disponibilidad(lista,0,12)],
            ['Cloro', disponibilidad(lista,0,10)]
        ],
        style=[
            ('GRID',(0,0),(-1,-1),0.5,colors.grey),
            ('BACKGROUND',(0,0),(6,0),colors.grey),
        ])
    story.append(t4)


    doc.build(story)

