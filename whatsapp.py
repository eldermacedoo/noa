# whatsapp.py
import os, json, requests
from dotenv import load_dotenv
from db import log_outbound

load_dotenv()
ACCESS_TOKEN = os.getenv("ACCESS_TOKEN")
PHONE_NUMBER_ID = os.getenv("PHONE_NUMBER_ID")

BASE_URL = f"https://graph.facebook.com/v22.0/{PHONE_NUMBER_ID}/messages"
HEADERS = {
    "Authorization": f"Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json"
}

def send_text(to_number: str, body: str) -> dict:
    """Envia mensagem de texto simples e grava no Mongo."""
    payload = {
        "messaging_product": "whatsapp",
        "to": to_number,
        "type": "text",
        "text": {"preview_url": False, "body": body}
    }
    r = requests.post(BASE_URL, headers=HEADERS, data=json.dumps(payload))
    data = r.json()
    log_outbound(wa_id=to_number, body=body, msg_type="text", api_resp=data, status_code=r.status_code)
    return {"status_code": r.status_code, "response": data}

def send_template(to_number: str, template_name: str, lang_code: str = "en_US", components: list | None = None) -> dict:
    """
    Envia template aprovado.
    components (opcional): lista no formato da Cloud API.
    """
    payload = {
        "messaging_product": "whatsapp",
        "to": to_number,
        "type": "template",
        "template": {
            "name": template_name,
            "language": {"code": lang_code}
        }
    }
    if components:
        payload["template"]["components"] = components

    r = requests.post(BASE_URL, headers=HEADERS, data=json.dumps(payload))
    data = r.json()
    log_outbound(wa_id=to_number, body=template_name, msg_type="template", api_resp=data, status_code=r.status_code)
    return {"status_code": r.status_code, "response": data}

def send_image_url(to_number: str, image_url: str, caption: str | None = None) -> dict:
    """Envia imagem por URL."""
    payload = {
        "messaging_product": "whatsapp",
        "to": to_number,
        "type": "image",
        "image": {"link": image_url, **({"caption": caption} if caption else {})}
    }
    r = requests.post(BASE_URL, headers=HEADERS, data=json.dumps(payload))
    data = r.json()
    log_outbound(wa_id=to_number, body=caption or "(image)", msg_type="image", api_resp=data, status_code=r.status_code)
    return {"status_code": r.status_code, "response": data}
