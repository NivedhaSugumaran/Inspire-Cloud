import pymysql
from datetime import datetime
from datetime  import date
import boto3
from botocore.exceptions import ClientError

REGION = 'ap-south-1'



def lambda_handler(event,context):
    """
    This function fetches content from mysql RDS instance
    """
    result = [] #list for expirydate
    duration=[] #list for difference(expiredate-currentdate)
    we=[] # list for date, userid and certname
    today = date.today() # current date
    conn = pymysql.connect(host='mynewdb.cnxnwp9zmsnt.ap-south-1.rds.amazonaws.com',
                             user='master',
                             password='12345678',
                             database='inspirecloud', connect_timeout=5) #rds connect

    print(date.today())
    with conn.cursor() as cur: # cursor->used to execute statements to communicate with the MySQL database
        
        cur.execute("""SELECT expirydate,id,certname FROM certificate;""") # execute ->executes the query
        conn.commit()  #This method sends a COMMIT statement to the MySQL server, committing the current transaction. 
        for i in cur:# appending to WE list
        #cur.close()
        	we.append(i)
        	result.append(i[0])
    #print(result)
    #print(we)
    le=len(result)
    for i in range(le):
    	res=result[i] - today #dateformat  
    	x=res.days #extract days
    	duration.append(x) #appending duration
    test=[]
    #print(duration)
    userid=[] #list for users with lessthan 50days of expiry of certificate
    for i in range(le):
    	if duration[i] < 50 :
    		with conn.cursor() as cur:
        		cur.execute("SELECT email FROM users where id = {};".format(we[i][1])) # fetching email from users table using id
        		conn.commit()
        		for k in cur:
    				 #cur.close()
    				 
        			 userid.append(k+(we[i][2],)+(we[i][0],)) #appending emailid, certificate and expirydate
    		
    		
    print(userid)
    

    for j in userid: # for SES -> EMAIL notification
        SENDER = "inspirecloud21@gmail.com"
        RECIPIENT = j[0]
        CERT=j[1]
        AWS_REGION = "ap-south-1"
        CERT=CERT.capitalize()
        DATE=j[2]
        EXPIRYDATE=DATE.strftime("%d/%m/%Y")
       # print(EXPIRYDATE)
        

        SUBJECT = CERT +" Certification Expiration Reminder!"

    # The email body for recipients with non-HTML email clients.
        BODY_TEXT = CERT +  "Your certificate is expiring soon!!!"
            
    # The HTML body of the email.
        BODY_HTML = """<html>
        <head></head>
        <body>
        <h1>"""+CERT +""" Certificate Expiry Reminder</h1>
        <p>Your certificate is expiring soon on """+EXPIRYDATE+""" !!!</p>
        </body>
        </html>"""            
    
    # The character encoding for the email.
        CHARSET = "UTF-8"
    
    # Create a new SES resource and specify a region.
        client = boto3.client('ses',region_name=AWS_REGION)
        try:
        #Provide the contents of the email.
            response = client.send_email(
                Destination={
                    'ToAddresses': [
                        RECIPIENT,
                    ],
                },
                Message={
                    'Body': {
                        'Html': {
                            'Charset': CHARSET,
                            'Data': BODY_HTML,
                        },
                        'Text': {
                            'Charset': CHARSET,
                            'Data': BODY_TEXT,
                        },
                    },
                    'Subject': {
                        'Charset': CHARSET,
                        'Data': SUBJECT,
                    },
                },
                Source=SENDER,
                # If you are not using a configuration set, comment or delete the
                # following line
            
            )
    # Display an error if something goes wrong.	
        except ClientError as e:
            print(e.response['Error']['Message'])
        else:
            print("Email sent! Message ID:"),
            print(response['MessageId'])
        


    

    
    		
    			
				
			
			
		
