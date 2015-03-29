#!/usr/bin/python
print 'content-type: text/html'
print
 
import cgi, cgitb, md5, os, random
cgitb.enable()
 
formData = cgi.FieldStorage()

#Gets all the Usernames and passwords
f = open('userpass.txt','r')
text = f.read()
lines = text.split("\n")
usernames = []
passwords = []
for i in range(len(lines)):
    lines[i] = lines[i].split(":")
for i in range(len(lines)-1):
    if lines[i] == ['']:
        lines.remove(lines[i])
    else:
        usernames.append(lines[i][0])
        passwords.append(lines[i][1])
f.close()

def validUser(username):
    if username.isalnum():
        return True
    else:
        return False

def validPass(password):
    number = False
    length = len(password) >= 6
    for c in password:
        if c.isdigit():
            number = True
    return number and length

# -----------------------------------------------------------------
#HEAD
print '''<html>
<head>
\t<title>Sign Up</title>
\t<link rel="stylesheet" type="text/css" href="">
</head>
<body> '''

user_alphanumeric = '<div class="floater"></div><div class="message">A username can only have letters and numbers.</div>'
user_taken = '<div class="floater"></div><div class="message">Username already taken.</div>'
pass_requirement = '<div class="floater"></div><div class="message">A password must be at least 6 characters and contain a number</div>'

if len(formData) == 0:
    print ''' SIGNUP FORM GOES HERE '''

elif 'user' in formData and 'pass' in formData:
    User = formData['user'].value
    Pass = formData['pass'].value
    if validUser(User) == False:
        print user_alphanumeric
    elif User in usernames:
        print user_taken
    elif validPass(Pass) == False:
        print pass_requirement
    else:
        #Add User+Pass to userpass.txt
        p = md5.new()
        p.update(Pass)
        hashed = p.hexdigest()
        ip = os.environ["REMOTE_ADDR"]
        f = open('userpass.txt','a')
        f.write(User+":"+hashed+":"+ip+"\n")
        f.close()

print '''<div class="floater"></div><div class="message"><a href="login.py">Login</a></div>
</body>
</html>'''
