#!/usr/bin/python

import sys, getopt
import csv
import MySQLdb

# UTILITY FUNCTIONS

def getId(sql):
    cursor = db.cursor()
    try:
        cursor.execute(sql)
        return cursor.fetchone()[0]
    except:
        return None;

def getIdRowsInDB():
    cursor = db.cursor()
    ids=[]
    try:
        cursor.execute("SELECT id FROM Datarows")
        result_set = cursor.fetchall()
        for row in result_set:
            ids.append(row[0])
        return ids
    except:
        return None

def getIdRow(datalogger_id, count, date):
    return int((str(datalogger_id) + count + "".join((date.split("-")))).replace(" ",""));

def insert(sql):
    cursor = db.cursor()
    try:
        cursor.execute(sql)
        db.commit()
    except:
        print "Error: an insertion failed"
        print sql[ 0 : 500]
        db.rollback()


# MAIN PART

inputfile = sys.argv[1]
print ">>> Processing file: " + inputfile
rows = csv.reader(open(inputfile, 'rb'))
rows = list(rows)
columns = len(rows[1])
print str(columns) + " columns and " + str(len(rows)) + " rows"

db = MySQLdb.connect("localhost","root","root","loggernetplus" )
print ">>> Connection to the database successful"


print "\n> STEP 1 - Processing data data about the Datalogger"

datalogger_infos = rows[0]
values = "'" + "','".join((rows[0][1],rows[0][3],rows[0][5],rows[0][7])) + "'"

sql_id_datalogger = "SELECT id FROM Dataloggers WHERE name='" + rows[0][7] + "';"
datalogger_id = getId(sql_id_datalogger)

if datalogger_id==None:
    print "A new datalogger has been detected: " + rows[0][7]
    sql_datalogger = "INSERT INTO Dataloggers(reference, model, processor, name) VALUES (" + values + ");" 
    insert(sql_datalogger)
    datalogger_id = getId(sql_id_datalogger)
else :
    print "The datalogger: " + rows[0][7] + " is already in the database"



print "\n> STEP 2 - Processing data about the Sensors"

sensors_infos = [rows[1], rows[2], rows[3]]
sensors_id = []
ignored = 0
added = 0
for i in range(2, columns):
    sql_id_sensor = "SELECT id FROM Sensors WHERE name='" + sensors_infos[0][i] + "' AND datalogger_id=" + str(datalogger_id) + ";"
    sensor_id = getId(sql_id_sensor)
    
    if sensor_id==None:
        print "A new sensor has been detected: " + sensors_infos[0][i]
        values = "('" + "','".join((sensors_infos[0][i], sensors_infos[1][i], sensors_infos[2][i])) + "'," + str(datalogger_id) + ")"
        sql_sensors = "INSERT INTO Sensors(name,unit,operation,datalogger_id) VALUES " + values + ";"
        insert(sql_sensors)
        sensor_id = getId(sql_id_sensor)
        added = added + 1
    else :
        ignored = ignored + 1

    sensors_id.append(sensor_id)

print str(added) + " sensors inserted | " + str(ignored) + " already in the database"

print "\n> STEP 3 - Processing rows"


datarows_ignore = getIdRowsInDB() # Contains the ids of the rows that are already in the database
values = []
ignored=0
for i in range(4, len(rows)-1):
    if len(rows[i])==columns:   
        row_id = getIdRow(datalogger_id, rows[i][1], rows[i][0].split(" ")[0])
        if not row_id in datarows_ignore:
            row_id = getIdRow(datalogger_id, rows[i][1], rows[i][0].split(" ")[0])
            values.append("(" + str(row_id) + "," + str(datalogger_id) + "," + rows[i][1].replace(" ", "") + ",'" + rows[i][0].split(" ")[0] + "')")
        else :
            ignored = ignored + 1

print str(len(values)) + " Datarows to be inserted | " + str(ignored) + " already in the database"
if not values==[] :
    sql_datarows = "INSERT INTO Datarows(id, datalogger_id, count_infile, measured_at) VALUES " + ",".join((values)) + ";"
    insert(sql_datarows)



print "\n> STEP 4 - Processing values"

values = []
ignored=0
for j in range(4, len(rows)-1):
    if len(rows[j])==columns: 
        row_id = getIdRow(datalogger_id, rows[j][1], rows[j][0].split(" ")[0])
        if not row_id in datarows_ignore:
            for i in range(2, columns):
                values.append("(" + ",".join((str(row_id),str(sensors_id[i-2]),rows[j][i]))+ ")")
        else :
            ignored = ignored + columns - 2

print str(len(values)) + " Data values to be inserted | " + str(ignored) + " already in the database"
if not values==[] :
    sql_data="INSERT INTO Data(datarow_id,sensor_id,data) VALUES " + ",".join((values)) + ";"
    insert(sql_data)

print "\n>>> " + inputfile + " processed\n"

