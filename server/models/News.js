const mongoose = require('mongoose');

const NewsSchema = new mongoose.Schema({
  title: { type: String, required: true },
  version: String,
  date: String,
  body: String,
  thumb: String,
  mediaType: { type: String, default: 'image' },
  mediaUrl: String,
});

module.exports = mongoose.model('News', NewsSchema);