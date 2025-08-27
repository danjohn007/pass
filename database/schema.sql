-- PASS Database Schema
-- Plataforma de Autoevaluación y Seguimiento Psicológico
-- MySQL 5.7 Compatible

-- Create database
CREATE DATABASE IF NOT EXISTS pass_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pass_db;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    age INT NULL,
    gender ENUM('male', 'female', 'other', 'prefer_not_to_say') NULL,
    country VARCHAR(100) NULL,
    consent_given BOOLEAN DEFAULT FALSE,
    role ENUM('user', 'psychologist', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT TRUE
);

-- Assessment types table
CREATE TABLE assessment_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(20) UNIQUE NOT NULL,
    description TEXT,
    questions JSON NOT NULL,
    scoring_info JSON NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- User assessments table
CREATE TABLE user_assessments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    assessment_type_id INT NOT NULL,
    responses JSON NOT NULL, -- Encrypted
    total_score INT NOT NULL,
    severity_level ENUM('minimal', 'mild', 'moderate', 'severe') NOT NULL,
    completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (assessment_type_id) REFERENCES assessment_types(id)
);

-- Daily tracking table
CREATE TABLE daily_tracking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    tracking_date DATE NOT NULL,
    mood_level INT NOT NULL CHECK (mood_level BETWEEN 1 AND 10),
    stress_level INT NOT NULL CHECK (stress_level BETWEEN 1 AND 10),
    anxiety_level INT NOT NULL CHECK (anxiety_level BETWEEN 1 AND 10),
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_date (user_id, tracking_date)
);

-- Resources table
CREATE TABLE resources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category ENUM('article', 'video', 'exercise', 'technique') NOT NULL,
    content TEXT NOT NULL,
    url VARCHAR(500) NULL,
    tags JSON NULL,
    is_featured BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Alerts table
CREATE TABLE alerts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    alert_type ENUM('high_anxiety', 'high_depression', 'crisis_risk') NOT NULL,
    message TEXT NOT NULL,
    is_acknowledged BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert sample assessment types
INSERT INTO assessment_types (name, code, description, questions, scoring_info) VALUES 
(
    'Escala de Ansiedad Generalizada (GAD-7)',
    'GAD7',
    'Cuestionario de 7 preguntas para evaluar síntomas de ansiedad generalizada',
    JSON_ARRAY(
        'Durante las últimas 2 semanas, ¿con qué frecuencia ha estado molesto por los siguientes problemas: Sentirse nervioso, ansioso o muy alterado?',
        'No ser capaz de parar o controlar las preocupaciones',
        'Preocuparse demasiado por diferentes cosas',
        'Problemas para relajarse',
        'Estar tan inquieto que le ha sido difícil permanecer sentado',
        'Enojarse o irritarse fácilmente',
        'Sentir miedo como si algo malo fuera a pasar'
    ),
    JSON_OBJECT(
        'scale', JSON_ARRAY('Para nada', 'Varios días', 'Más de la mitad de los días', 'Casi todos los días'),
        'values', JSON_ARRAY(0, 1, 2, 3),
        'ranges', JSON_OBJECT(
            'minimal', JSON_ARRAY(0, 4),
            'mild', JSON_ARRAY(5, 9),
            'moderate', JSON_ARRAY(10, 14),
            'severe', JSON_ARRAY(15, 21)
        )
    )
),
(
    'Cuestionario de Salud del Paciente (PHQ-9)',
    'PHQ9',
    'Cuestionario de 9 preguntas para evaluar síntomas de depresión',
    JSON_ARRAY(
        'Durante las últimas 2 semanas, ¿con qué frecuencia ha tenido molestias debido a: Poco interés o placer en hacer cosas?',
        'Sentirse desanimado, deprimido o sin esperanzas',
        'Problemas para conciliar el sueño, mantenerse dormido o dormir demasiado',
        'Sentirse cansado o tener poca energía',
        'Poco apetito o comer en exceso',
        'Sentirse mal consigo mismo, o que es un fracaso o que ha quedado mal con usted mismo o con su familia',
        'Problemas para concentrarse en cosas como leer el periódico o ver televisión',
        'Moverse o hablar tan lento que otras personas podrían haberlo notado. O lo contrario: estar tan inquieto o agitado que se ha estado moviendo mucho más de lo normal',
        'Pensamientos de que estaría mejor muerto o de lastimarse de alguna manera'
    ),
    JSON_OBJECT(
        'scale', JSON_ARRAY('Para nada', 'Varios días', 'Más de la mitad de los días', 'Casi todos los días'),
        'values', JSON_ARRAY(0, 1, 2, 3),
        'ranges', JSON_OBJECT(
            'minimal', JSON_ARRAY(0, 4),
            'mild', JSON_ARRAY(5, 9),
            'moderate', JSON_ARRAY(10, 14),
            'severe', JSON_ARRAY(15, 27)
        )
    )
);

-- Insert sample users (password is 'password123' hashed)
INSERT INTO users (email, password_hash, first_name, last_name, age, gender, country, consent_given, role) VALUES 
('admin@pass.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'PASS', 30, 'other', 'México', TRUE, 'admin'),
('user@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Juan', 'Pérez', 25, 'male', 'México', TRUE, 'user'),
('maria@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'María', 'García', 32, 'female', 'España', TRUE, 'user');

-- Insert sample resources
INSERT INTO resources (title, category, content, tags, is_featured) VALUES 
(
    'Técnicas de Respiración para la Ansiedad',
    'technique',
    'La respiración profunda y controlada puede ayudar a reducir los niveles de ansiedad. Practica inhalar durante 4 segundos, mantener 4 segundos, y exhalar durante 6 segundos.',
    JSON_ARRAY('ansiedad', 'respiración', 'relajación'),
    TRUE
),
(
    'Ejercicio de Mindfulness: Atención Plena',
    'exercise',
    'Dedica 5-10 minutos al día a practicar mindfulness. Siéntate cómodamente, cierra los ojos y presta atención a tu respiración sin juzgar tus pensamientos.',
    JSON_ARRAY('mindfulness', 'meditación', 'bienestar'),
    TRUE
),
(
    'Entendiendo la Depresión',
    'article',
    'La depresión es un trastorno del estado de ánimo que afecta cómo te sientes, piensas y manejas las actividades diarias. Es importante buscar ayuda profesional si experimentas síntomas persistentes.',
    JSON_ARRAY('depresión', 'educación', 'salud mental'),
    FALSE
);

-- Insert sample daily tracking data
INSERT INTO daily_tracking (user_id, tracking_date, mood_level, stress_level, anxiety_level, notes) VALUES 
(2, CURDATE() - INTERVAL 7 DAY, 6, 4, 3, 'Día regular, trabajo estresante'),
(2, CURDATE() - INTERVAL 6 DAY, 7, 3, 2, 'Mejor día, ejercicio por la mañana'),
(2, CURDATE() - INTERVAL 5 DAY, 5, 6, 5, 'Día difícil, muchas preocupaciones'),
(2, CURDATE() - INTERVAL 4 DAY, 8, 2, 2, 'Excelente día, tiempo con familia'),
(2, CURDATE() - INTERVAL 3 DAY, 6, 4, 4, 'Día promedio'),
(2, CURDATE() - INTERVAL 2 DAY, 7, 3, 3, 'Buen día, práctica de meditación'),
(2, CURDATE() - INTERVAL 1 DAY, 6, 5, 4, 'Algo de estrés laboral');

-- Create indexes for better performance
CREATE INDEX idx_user_assessments_user_id ON user_assessments(user_id);
CREATE INDEX idx_user_assessments_completed_at ON user_assessments(completed_at);
CREATE INDEX idx_daily_tracking_user_date ON daily_tracking(user_id, tracking_date);
CREATE INDEX idx_alerts_user_id ON alerts(user_id);
CREATE INDEX idx_resources_category ON resources(category);