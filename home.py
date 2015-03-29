import cgi,cgitb,md5,os,random
cgitb.enable()

formData = cgi.FieldStorage()

#Get usernames and passwords
f=open('data/userpass.txt','r')
g=f.read()
lines=g.split('\n')
info=[]
for y in range(len(lines)-1):
    info+= lines[y].split(':')
f.close()

#get people that are logged in
x = open('data/loggedOn.txt','r')
text = x.read()
users = text.split("\n")
loggedIn = []
for i in range(len(users)):
    users[i] = users[i].split(",")
for i in range(len(users)-1):
    loggedIn.append(users[i][0])

print '''<html>
\t<head>
\t\t<title>Home</title>
\t\t<link rel="stylesheet" type="text/css" href="theme.css">
\t</head>
\t<body>'''

#IS USER LOGGED IN?
if 'user' in formData and 'id' in formData:
    userName = formData['user'].value
    ID = formData['id'].value
    s = False
    for u in users:
        if u[0] == userName and u[1] == ID:
            s = True
            
    #ASKS USER TO LOG IN
    if s == False:
        print '''\t\t<div class="post"><center><h1>You are not logged in</h1><br><a href="login.py">Log In</a></center></div>'''

    #WHAT SHOWS UP WHEN USER IS LOGGED IN
    else:
        print '''\t\t<a href="homepage.py?user=''' + userName + "&id="+ID+ '''">Welcome '''+userName+'''!</a><br>\n
<a href="login.py">Log Out</a><br>'''

