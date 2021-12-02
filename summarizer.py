# pip install transformers
# pip3 install torch torchvision torchaudio
from transformers import pipeline
# import os
# setting GPU and model to use
# os.environ["CUDA_VISIBLE_DEVICES"] = "0"
# summarizer = pipeline("summarization")

summarizer = pipeline("summarization", model="t5-base", tokenizer="t5-base", framework="tf")
from bs4 import BeautifulSoup
import requests
import sys

#webpage path for scraping text

if __name__ == '__main__':
    if(len(sys.argv) > 1):
        url = sys.argv[1]
        
        # URL = 'https://www.sciencedirect.com/science/article/pii/S1319157820303712'
        # URL = 'https://medium.com/trymito/3-python-tools-every-data-scientist-should-use-a250256cfbac'
        # URL = 'https://intervarsity.org/blog/wonder-rediscovering-childlike-wonder-your-faith'
        r = requests.get(url)
        r.text

        # using html parser to sort out text only 
        soup = BeautifulSoup(r.text,'html.parser')

        #scraping only title and paragraph
        results = soup.find_all(['h1', 'p'])

        #saving the results generated
        text = [result.text for result in results]
        ARTICLE = ' '.join(text)

        #visualizing scraping result 
        print(ARTICLE)

        #setting chunk length to 500 words
        max_chunk = 500
         
        #removing special characters and replacing with end of sentence
        ARTICLE = ARTICLE.replace('.', '.<eos>')
        ARTICLE = ARTICLE.replace('?', '?<eos>')
        ARTICLE = ARTICLE.replace('!', '!<eos>')

        #splitting out each sentence from the text into words 
        sentences = ARTICLE.split('<eos>')
        current_chunk = 0 
        chunks = []

        #looping through split text to process
        for sentence in sentences:
            if len(chunks) == current_chunk + 1: 
                if len(chunks[current_chunk]) + len(sentence.split(' ')) <= max_chunk:
                    chunks[current_chunk].extend(sentence.split(' '))
                else:
                    current_chunk += 1
                    chunks.append(sentence.split(' '))
            else:
                print(current_chunk)
                chunks.append(sentence.split(' '))
         
        for chunk_id in range(len(chunks)):
            chunks[chunk_id] = ' '.join(chunks[chunk_id])

        #setting our summarizer
        res = summarizer(chunks, max_length=50, min_length=5, do_sample=False)
        # summary_text = summarizer(chunks, max_length=30, min_length=5, do_sample=False) [0] ['summary_text']

        #obtaining the resultant summary
        print(' '.join([summ['summary_text'] for summ in res]))
        # print(summary_text)