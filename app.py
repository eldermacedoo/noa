# app.py
import os
from flask import Flask, request, jsonify
from dotenv import load_dotenv
from db import messages, now_utc, update_status

load_dotenv()
VERIFY_TOKEN = os.getenv("VERIFY_TOKEN", "meu_token_webhook")

app = Flask(__name__)

@app.get("/webhook")
def verify():
    mode = request.args.get("hub.mode")
    token = request.args.get("hub.verify_token")
    challenge = request.args.get("hub.challenge")
    if mode == "subscribe" and token == VERIFY_TOKEN:
        return challenge, 200
    return "forbidden", 403

@app.post("/webhook")
def receive():
    payload = request.get_json(force=True, silent=True) or {}
    try:
        for entry in payload.get("entry", []):
            for change in entry.get("changes", []):
                value = change.get("value", {})

                # Mensagens recebidas
                for msg in value.get("messages", []) or []:
                    wa_id = (value.get("contacts", [{}])[0].get("wa_id") 
                             if value.get("contacts") else msg.get("from"))
                    msg_type = msg.get("type")
                    body = msg.get("text", {}).get("body") if msg_type == "text" else None

                    doc = {
                        "message_id": msg.get("id"),
                        "wa_id": wa_id,
                        "from_number": msg.get("from"),
                        "to_number": value.get("metadata", {}).get("phone_number_id"),
                        "direction": "inbound",
                        "type": msg_type,
                        "body": body,
                        "media": [],
                        "status": "received",
                        "created_at": now_utc(),
                        "raw": msg
                    }
                    messages.update_one({"message_id": doc["message_id"]}, {"$setOnInsert": doc}, upsert=True)

                # Status de mensagens enviadas
                for st in value.get("statuses", []) or []:
                    update_status(st.get("id"), st.get("status"))

        return jsonify({"ok": True}), 200
    except Exception as e:
        return jsonify({"ok": False, "error": str(e)}), 200

if __name__ == "__main__":
    app.run(port=3000, debug=True)
