import requests
from sklearn.metrics import accuracy_score, precision_score, recall_score, f1_score, classification_report, confusion_matrix
import pandas as pd

API_URL = "http://127.0.0.1:5000/predict"

test_data = [
    # Positif
    {"text": "Aplikasi ini sangat membantu dan mudah digunakan", "label": "Positif"},
    {"text": "Pelayanan sangat cepat dan ramah, saya puas sekali", "label": "Positif"},
    {"text": "Fitur survei online ini sangat memudahkan saya mengisi tanpa harus login", "label": "Positif"},
    {"text": "Tampilan website rapi dan enak dilihat", "label": "Positif"},
    {"text": "Terima kasih, sistemnya sangat membantu pekerjaan kami sehari-hari", "label": "Positif"},
    {"text": "Saya sangat senang dengan kemudahan akses yang diberikan", "label": "Positif"},
    {"text": "Proses pengisian survei sangat singkat dan tidak merepotkan", "label": "Positif"},
    {"text": "Pelayanan publik di sini sudah jauh lebih baik dari sebelumnya", "label": "Positif"},
    {"text": "Petugasnya sangat sopan dan membantu menjelaskan dengan jelas", "label": "Positif"},
    {"text": "Website ini responsif dan cepat diakses dari hp", "label": "Positif"},
    {"text": "Sangat puas dengan kemudahan dan kelengkapan fitur yang disediakan", "label": "Positif"},
    {"text": "Saya merasa keluhan saya benar-benar didengar dan ditindaklanjuti", "label": "Positif"},

    # Negatif
    {"text": "Pelayanan sangat buruk dan lambat", "label": "Negatif"},
    {"text": "Website sering error saat saya coba isi survei", "label": "Negatif"},
    {"text": "Saya kecewa karena tidak ada tindak lanjut dari keluhan saya", "label": "Negatif"},
    {"text": "Loading aplikasi sangat lama dan menyebalkan", "label": "Negatif"},
    {"text": "Petugas kurang ramah dan terkesan tidak peduli", "label": "Negatif"},
    {"text": "Sistem ini banyak bug dan sering gagal menyimpan jawaban", "label": "Negatif"},
    {"text": "Saya sangat tidak puas dengan respon yang lambat", "label": "Negatif"},
    {"text": "Tampilan website membingungkan dan tidak user friendly", "label": "Negatif"},
    {"text": "Proses pelayanan terlalu berbelit dan menyita banyak waktu", "label": "Negatif"},
    {"text": "Banyak pertanyaan yang tidak relevan dan membuat bingung", "label": "Negatif"},
    {"text": "Saya pernah komplain tapi tidak ada balasan sama sekali", "label": "Negatif"},
    {"text": "Sangat mengecewakan, fitur yang dijanjikan tidak berfungsi", "label": "Negatif"},

    # Netral
    {"text": "Cukup baik tapi masih ada yang perlu diperbaiki", "label": "Netral"},
    {"text": "Aplikasinya standar saja, tidak ada yang istimewa", "label": "Netral"},
    {"text": "Pelayanan biasa saja, sesuai dengan yang diharapkan", "label": "Netral"},
    {"text": "Tidak ada keluhan khusus, semuanya berjalan normal", "label": "Netral"},
    {"text": "Survei ini lumayan, walau ada beberapa pertanyaan yang kurang jelas", "label": "Netral"},
    {"text": "Saya rasa pelayanannya sudah cukup memadai untuk saat ini", "label": "Netral"},
    {"text": "Tidak terlalu bagus tapi juga tidak buruk", "label": "Netral"},
    {"text": "Sistemnya cukup mudah dipahami meski ada bagian yang perlu disesuaikan", "label": "Netral"},
    {"text": "Saya belum bisa menilai karena baru pertama kali menggunakan", "label": "Netral"},
    {"text": "Secara umum sudah sesuai harapan saya", "label": "Netral"},
    {"text": "Website ini biasa saja seperti aplikasi sejenis lainnya", "label": "Netral"},
    {"text": "Pelayanannya standar, tidak ada yang menonjol", "label": "Netral"},

    {"text": "Awalnya saya kira sulit, tapi ternyata cukup mudah dipahami", "label": "Positif"},
    {"text": "Fiturnya lengkap walaupun tampilannya kurang menarik", "label": "Netral"},
    {"text": "Responnya cepat tapi solusinya belum menyelesaikan masalah saya", "label": "Negatif"},
    {"text": "Survei ini membantu menyampaikan pendapat saya dengan baik", "label": "Positif"},
]

y_true = []
y_pred = []
results_detail = []

print("Menjalankan evaluasi via Flask API...\n")

for item in test_data:
    response = requests.post(API_URL, json={"text": item["text"]})
    result = response.json()

    predicted_label = result['sentiment']
    confidence = result['confidence']

    y_true.append(item['label'])
    y_pred.append(predicted_label)

    results_detail.append({
        'Teks': item['text'][:50],
        'Label Asli': item['label'],
        'Prediksi': predicted_label,
        'Confidence': confidence,
        'Status': '✓' if item['label'] == predicted_label else '✗'
    })

df_results = pd.DataFrame(results_detail)
print(df_results.to_string(index=False))

print("\n" + "="*50)
accuracy = accuracy_score(y_true, y_pred)
precision = precision_score(y_true, y_pred, average='weighted', zero_division=0)
recall = recall_score(y_true, y_pred, average='weighted', zero_division=0)
f1 = f1_score(y_true, y_pred, average='weighted', zero_division=0)

print(f"Accuracy  : {accuracy:.4f} ({accuracy*100:.2f}%)")
print(f"Precision : {precision:.4f} ({precision*100:.2f}%)")
print(f"Recall    : {recall:.4f} ({recall*100:.2f}%)")
print(f"F1-Score  : {f1:.4f} ({f1*100:.2f}%)")
print("="*50)

print("\nClassification Report:")
print(classification_report(y_true, y_pred, zero_division=0))

labels = ['Positif', 'Negatif', 'Netral']
cm = confusion_matrix(y_true, y_pred, labels=labels)
print("\nConfusion Matrix:")
print(pd.DataFrame(cm, index=labels, columns=labels))

df_results.to_csv('hasil_evaluasi.csv', index=False)
print("\nHasil disimpan ke hasil_evaluasi.csv")