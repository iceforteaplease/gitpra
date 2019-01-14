import sqlite3

conn = sqlite3.connect('goalspractice.sqlite')
cur = conn.cursor()

#cur.execute('DROP TABLE IF EXISTS Work_2018')
#cur.execute('DROP TABLE IF EXISTS Work_2019')
#cur.execute('CREATE TABLE IF NOT EXISTS Work_2018 (Week_of TEXT, Hours INTEGER)')

#dates = ['October 15', 'October 22', 'October 29',
            #'November 5', 'November 12', 'November 19', 'November 26',
                #'December 3', 'December 10', 'Vacation!!!']
#for each in dates :
    #cur.execute('INSERT INTO Work_2018(Week_of, Hours) VALUES (?, 0)', (each,))

cur.execute('''CREATE TABLE IF NOT EXISTS Work_2019 (week TEXT, code_hours INTEGER,
                bjj_days INTEGER)''')

weeks = list(range(1,53))
#for week in weeks :
    #cur.execute('INSERT INTO Work_2019(week, code_hours, bjj_days) VALUES (?,0,0)', (week,))
x = input('Hours put in? ')
y = input('Bjj? ')
try :
    hours = int(x)
    bjj = int(y)
except :
    print('No sir, put real numbers')
    quit()

#cur.execute('SELECT * FROM Work_2018 WHERE Week_of = ?', (dates[9],))
#num = cur.fetchone()[1]
#print('Before:', num)
#cur.execute('UPDATE Work_2018 SET Hours = ? WHERE Week_of = ?', (num + hours, dates[9],))
#cur.execute('SELECT * FROM Work_2018 WHERE Week_of = ?', (dates[9],))
#print('After:', cur.fetchone()[1])
cur.execute('SELECT * FROM Work_2019 WHERE week = ?', (weeks[2],))
study = cur.fetchone()[1]
cur.execute('SELECT * FROM Work_2019 WHERE week = ?', (weeks[2],))
train = cur.fetchone()[2]
cur.execute('UPDATE Work_2019 SET code_hours = ? WHERE week = ?', (study + hours, weeks[2]))
cur.execute('UPDATE Work_2019 SET bjj_days = ? WHERE week = ?', (train + bjj, weeks[2]))

conn.commit()
cur.close()
print('Database updated, added', hours, 'hours and', bjj, 'days')

import datetime

today = datetime.date.today()
future = datetime.date(2019, 12, 28)
diff = future - today
sdiff = str(diff)
print(sdiff[:3], 'days left in year')
