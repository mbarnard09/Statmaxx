#!/usr/bin/python
import praw
import string
import re
from praw.models import MoreComments
from datetime import datetime
import json
import io
import time
import nltk
from nltk.tokenize import sent_tokenize
from nltk import word_tokenize,sent_tokenize
#download(nltk)
import pandas as pd
import string
from nltk.sentiment.vader import SentimentIntensityAnalyzer
#nltk.downloader.download('vader_lexicon')
import mysql.connector as mariadb
import sys


def findWord(w):
     return re.compile(r'\b({0})\b'.format(w), flags=re.IGNORECASE).search


reddit = praw.Reddit(client_id= 'jpGXLl8tnCEF9Q',
                     client_secret = 'm4hz3scosoz-gYXFJDPWdgJeo4s',
                     username= 'statmaxx',
                     password= 'Pizza1212',
                     user_agent= 'statmaxxagent')

subreddit = reddit.subreddit('robinhoodpennystocks')

sticky = subreddit.sticky()
top_python = subreddit.hot(limit= 10)
now = datetime.now()
timeStart = now.strftime("%H:%M:%S")
date = datetime.today()
commentarray = []
source = 'robinhoodpennystocks'

mariadb_connection = mariadb.connect(user = 'admin', password = 'Pizza1212', database = 'statmaxx')
cursor = mariadb_connection.cursor()

add_data = ("INSERT INTO maindata "
            "(sym, mentions, time, positive, negative, neutral, date, source)"
            "VALUES (%s, %s, %s, %s, %s, %s, %s, %s)")

add_data2 = ("INSERT INTO comments "
            "(sym, comment, source, date, time)"
            "VALUES (%s, %s, %s, %s, %s)")

print("retrieving from Reddit...")

#scrapes top posts that arent stickied in last hour adds comments to array
for submission in top_python:
    if submission == sticky:
        continue
    submission.comments.replace_more(limit=None)
    for comment in submission.comments.list():
        commentarray.append(comment.body)

#scrapes stickied post for post in last hour

sticky.comments.replace_more(limit=30)
for comment in sticky.comments.list():
    commentarray.append(comment.body)


symtxt = open(r"/var/www/html/symbolnames.txt", "r")
print(len(commentarray))


print("finding symbols in strings...")
sid = SentimentIntensityAnalyzer()

#loading bar
toolbar_width = 40
sys.stdout.write("[%s]" % (" " * toolbar_width))
sys.stdout.flush()
sys.stdout.write("\b" * (toolbar_width+1))
j = 1

for line in symtxt:
    line = line.strip()
    line = line.translate(line.maketrans("", "", string.punctuation))
    symname = line
    mentions = 0
    positiveCount = 0
    negativeCount = 0
    neutralCount = 0
    for i in commentarray:
        i.lower()
        if findWord(line)(i):
            #comment data
            data2 = (symname, i, source, date, timeStart)
            cursor.execute(add_data2, data2)
            mariadb_connection.commit()
            
            mentions = mentions + 1
            ss = sid.polarity_scores(i)
            if ss["compound"] == 0.0:
                neutralCount += 1
            elif ss["compound"] > 0.0:
                positiveCount += 1
            else:
                negativeCount += 1

        else:
            continue
    #query commit to database
    if mentions > 0:
        data = (symname, mentions, timeStart, positiveCount, negativeCount, neutralCount, date, source)
        cursor.execute(add_data, data)
        mariadb_connection.commit()
    j = j + 1
    #loading bar
    if j % 200 == 0:
        sys.stdout.write("-")
        sys.stdout.flush()
cursor.close()
mariadb_connection.close()
