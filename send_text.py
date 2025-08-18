import requests
import json
import os
from dotenv import load_dotenv

# Carregar token do .env
load_dotenv()
ACCESS_TOKEN = os.getenv("ACCESS_TOKEN")
PHONE_NUMBER_ID = os.getenv("PHONE_NUMBER_ID")

url = f"https://graph.facebook.com/v22.0/{PHONE_NUMBER_ID}/messages"

payload = {
    "messaging_product": "whatsapp",
    "recipient_type": "individual",
    "to": "5546991257620",  # número de destino no formato E.164
    "type": "text",
    "text": {
        "preview_url": False,
        "body": "Oiiii 👋 este é um texto livre!"
    }
}

headers = {
    "Content-Type": "application/json",
    "Authorization": f"Bearer {ACCESS_TOKEN}"
}

response = requests.post(url, headers=headers, data=json.dumps(payload))

print("Status:", response.status_code)
print("Resposta:", response.text)
