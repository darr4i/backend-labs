const express = require('express');
const router = express.Router();
const Book = require('../models/Book');

// Показати всі книги
router.get('/', async (req, res) => {
  const books = await Book.find().sort({ created_at: -1 });
  res.render('index', { books });
});

// Показати форму додавання книги
router.get('/add', (req, res) => {
  res.render('add');
});

// Додати нову книгу
router.post('/add', async (req, res) => {
  const { title, author, year, author_address, publisher_address, price, bookstore } = req.body;
  await Book.create({ title, author, year, author_address, publisher_address, price, bookstore });
  res.redirect('/');
});

// Показати форму редагування
router.get('/edit/:id', async (req, res) => {
  const book = await Book.findById(req.params.id);
  res.render('edit', { book });
});

// Зберегти редаговану книгу
router.post('/edit/:id', async (req, res) => {
  const { title, author, year, author_address, publisher_address, price, bookstore } = req.body;
  await Book.findByIdAndUpdate(req.params.id, {
    title, author, year, author_address, publisher_address, price, bookstore
  });
  res.redirect('/');
});

// Видалити книгу
router.get('/delete/:id', async (req, res) => {
  await Book.findByIdAndDelete(req.params.id);
  res.redirect('/');
});

// Вивід JSON API
router.get('/api/books', async (req, res) => {
  const books = await Book.find();
  res.json(books);
});

module.exports = router;
