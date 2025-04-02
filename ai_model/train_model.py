import tensorflow as tf
import numpy as np
import pandas as pd
from tensorflow.keras.models import Model
from tensorflow.keras.layers import Input, Embedding, Flatten, Dot
import json

# Load Data from MySQL (replace with your DB connection)
def load_data():
    user_interactions = pd.read_csv("user_interactions.csv")  # Export interactions
    return user_interactions

# Build Recommendation Model
def build_model(num_users, num_products, latent_dim=50):
    user_input = Input(shape=(1,))
    product_input = Input(shape=(1,))

    user_embedding = Embedding(num_users, latent_dim)(user_input)
    product_embedding = Embedding(num_products, latent_dim)(product_input)

    user_vec = Flatten()(user_embedding)
    product_vec = Flatten()(product_embedding)

    dot_product = Dot(axes=1)([user_vec, product_vec])

    model = Model([user_input, product_input], dot_product)
    model.compile(optimizer='adam', loss='mse')
    return model

# Train & Save Model
data = load_data()
num_users = data['user_id'].nunique()
num_products = data['product_id'].nunique()

model = build_model(num_users, num_products)
model.fit([data['user_id'], data['product_id']], data['interaction_score'], epochs=5)

model.save("ai_model/recommendation_model")
print(" Model trained & saved!")
