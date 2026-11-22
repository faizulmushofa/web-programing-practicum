-- Migration: 001_create_initial_schema
-- Database: SQLite (apps/backend/data.db)

CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS media (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    url_image TEXT,
    rating REAL,
    episodes INTEGER,
    status TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS message (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL,
    detail TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Seed Initial Data untuk Media Katalog Demo
INSERT INTO media (title, url_image, rating, episodes, status) VALUES 
('One Piece', 'https://media.kitsu.app/anime/poster_images/12/medium.jpg', 86.4, 1100, 'current'),
('Attack on Titan', 'https://media.kitsu.app/anime/poster_images/7442/medium.jpg', 87.2, 87, 'finished'),
('Jujutsu Kaisen', 'https://media.kitsu.app/anime/poster_images/42765/medium.jpg', 85.1, 24, 'finished'),
('Frieren: Beyond Journey''s End', 'https://media.kitsu.app/anime/poster_images/46474/medium.jpg', 91.5, 28, 'finished'),
('Spirited Away', 'https://media.kitsu.app/anime/poster_images/176/medium.jpg', 89.0, 1, 'finished'),
('Demon Slayer', 'https://media.kitsu.app/anime/poster_images/41370/medium.jpg', 84.3, 26, 'finished');
