from flask import Flask, request, jsonify
from transformers import pipeline

app = Flask(__name__)

print("Loading model...")
sentiment_pipeline = pipeline(
    "text-classification",
    model="mdhugol/indonesia-bert-sentiment-classification",
    top_k=None
)
print("Model loaded!")

label_map = {
    'LABEL_0': 'Positif',
    'LABEL_1': 'Netral',
    'LABEL_2': 'Negatif'
}

THRESHOLD = 0.75  # hasil tuning, F1-Score terbaik (75.70%)

@app.route('/predict', methods=['POST'])
def predict():
    data = request.get_json()
    if not data or 'text' not in data:
        return jsonify({'error': 'Teks tidak ditemukan'}), 400

    text = data['text']
    if not text.strip():
        return jsonify({'error': 'Teks kosong'}), 400

    results = sentiment_pipeline(text)[0]
    best = max(results, key=lambda x: x['score'])

    # Terapkan threshold
    if best['score'] < THRESHOLD:
        sentiment = 'Netral'
    else:
        sentiment = label_map.get(best['label'], best['label'])

    return jsonify({
        'text': text,
        'sentiment': sentiment,
        'confidence': round(best['score'], 4)
    })

@app.route('/health', methods=['GET'])
def health():
    return jsonify({'status': 'ok'})

if __name__ == '__main__':
    app.run(debug=True, port=5000)