const mongoose = require('mongoose');

const bookSchema = new mongoose.Schema({
  title: { type: String, required: true },
  author: String,
  year: String,
  author_address: String,
  publisher_address: String,
  price: Number,
  bookstore: String,
  created_at: { type: Date, default: Date.now }
});

module.exports = mongoose.model('Book', bookSchema);
