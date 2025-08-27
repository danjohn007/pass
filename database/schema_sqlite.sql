-- PASS Database Schema for SQLite
-- Plataforma de Autoevaluación y Seguimiento Psicológico

-- Users table
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email TEXT UNIQUE NOT NULL,
    password_hash TEXT NOT NULL,
    first_name TEXT NOT NULL,
    last_name TEXT NOT NULL,
    age INTEGER NULL,
    gender TEXT CHECK(gender IN ('male', 'female', 'other', 'prefer_not_to_say')) NULL,
    country TEXT NULL,
    consent_given INTEGER DEFAULT 0,
    role TEXT CHECK(role IN ('user', 'psychologist', 'admin')) DEFAULT 'user',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    last_login DATETIME NULL,
    is_active INTEGER DEFAULT 1
);

-- Assessment types table
CREATE TABLE assessment_types (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    code TEXT UNIQUE NOT NULL,
    description TEXT,
    questions TEXT NOT NULL,
    scoring_info TEXT NOT NULL,
    is_active INTEGER DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- User assessments table
CREATE TABLE user_assessments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    assessment_type_id INTEGER NOT NULL,
    responses TEXT NOT NULL,
    total_score INTEGER NOT NULL,
    severity_level TEXT CHECK(severity_level IN ('minimal', 'mild', 'moderate', 'severe')) NOT NULL,
    completed_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (assessment_type_id) REFERENCES assessment_types(id)
);

-- Daily tracking table
CREATE TABLE daily_tracking (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    tracking_date DATE NOT NULL,
    mood_level INTEGER NOT NULL CHECK (mood_level BETWEEN 1 AND 10),
    stress_level INTEGER NOT NULL CHECK (stress_level BETWEEN 1 AND 10),
    anxiety_level INTEGER NOT NULL CHECK (anxiety_level BETWEEN 1 AND 10),
    notes TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE(user_id, tracking_date)
);

-- Resources table
CREATE TABLE resources (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    category TEXT CHECK(category IN ('article', 'video', 'exercise', 'technique')) NOT NULL,
    content TEXT NOT NULL,
    url TEXT NULL,
    tags TEXT NULL,
    is_featured INTEGER DEFAULT 0,
    is_active INTEGER DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Alerts table
CREATE TABLE alerts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    alert_type TEXT CHECK(alert_type IN ('high_anxiety', 'high_depression', 'crisis_risk')) NOT NULL,
    message TEXT NOT NULL,
    is_acknowledged INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert sample assessment types
INSERT INTO assessment_types (name, code, description, questions, scoring_info) VALUES 
(
    'Escala de Ansiedad Generalizada (GAD-7)',
    'GAD7',
    'Cuestionario de 7 preguntas para evaluar síntomas de ansiedad generalizada',
    '["Durante las últimas 2 semanas, ¿con qué frecuencia ha estado molesto por los siguientes problemas: Sentirse nervioso, ansioso o muy alterado?", "No ser capaz de parar o controlar las preocupaciones", "Preocuparse demasiado por diferentes cosas", "Problemas para relajarse", "Estar tan inquieto que le ha sido difícil permanecer sentado", "Enojarse o irritarse fácilmente", "Sentir miedo como si algo malo fuera a pasar"]',
    '{"scale": ["Para nada", "Varios días", "Más de la mitad de los días", "Casi todos los días"], "values": [0, 1, 2, 3], "ranges": {"minimal": [0, 4], "mild": [5, 9], "moderate": [10, 14], "severe": [15, 21]}}'
),
(
    'Cuestionario de Salud del Paciente (PHQ-9)',
    'PHQ9',
    'Cuestionario de 9 preguntas para evaluar síntomas de depresión',
    '["Durante las últimas 2 semanas, ¿con qué frecuencia ha tenido molestias debido a: Poco interés o placer en hacer cosas?", "Sentirse desanimado, deprimido o sin esperanzas", "Problemas para conciliar el sueño, mantenerse dormido o dormir demasiado", "Sentirse cansado o tener poca energía", "Poco apetito o comer en exceso", "Sentirse mal consigo mismo, o que es un fracaso o que ha quedado mal con usted mismo o con su familia", "Problemas para concentrarse en cosas como leer el periódico o ver televisión", "Moverse o hablar tan lento que otras personas podrían haberlo notado. O lo contrario: estar tan inquieto o agitado que se ha estado moviendo mucho más de lo normal", "Pensamientos de que estaría mejor muerto o de lastimarse de alguna manera"]',
    '{"scale": ["Para nada", "Varios días", "Más de la mitad de los días", "Casi todos los días"], "values": [0, 1, 2, 3], "ranges": {"minimal": [0, 4], "mild": [5, 9], "moderate": [10, 14], "severe": [15, 27]}}'
);

-- Insert sample users (password is 'password123' hashed)
INSERT INTO users (email, password_hash, first_name, last_name, age, gender, country, consent_given, role) VALUES 
('admin@pass.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'PASS', 30, 'other', 'México', 1, 'admin'),
('user@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Juan', 'Pérez', 25, 'male', 'México', 1, 'user'),
('maria@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'María', 'García', 32, 'female', 'España', 1, 'user');

-- Insert sample resources
INSERT INTO resources (title, category, content, tags, is_featured) VALUES 
(
    'Técnicas de Respiración para la Ansiedad',
    'technique',
    'La respiración profunda y controlada puede ayudar a reducir los niveles de ansiedad. Practica inhalar durante 4 segundos, mantener 4 segundos, y exhalar durante 6 segundos.',
    '["ansiedad", "respiración", "relajación"]',
    1
),
(
    'Ejercicio de Mindfulness: Atención Plena',
    'exercise',
    'Dedica 5-10 minutos al día a practicar mindfulness. Siéntate cómodamente, cierra los ojos y presta atención a tu respiración sin juzgar tus pensamientos.',
    '["mindfulness", "meditación", "bienestar"]',
    1
),
(
    'Entendiendo la Depresión',
    'article',
    'La depresión es un trastorno del estado de ánimo que afecta cómo te sientes, piensas y manejas las actividades diarias. Es importante buscar ayuda profesional si experimentas síntomas persistentes.',
    '["depresión", "educación", "salud mental"]',
    0
);

-- Insert sample daily tracking data for demo user
INSERT INTO daily_tracking (user_id, tracking_date, mood_level, stress_level, anxiety_level, notes) VALUES 
(2, date('now', '-7 days'), 6, 4, 3, 'Día regular, trabajo estresante'),
(2, date('now', '-6 days'), 7, 3, 2, 'Mejor día, ejercicio por la mañana'),
(2, date('now', '-5 days'), 5, 6, 5, 'Día difícil, muchas preocupaciones'),
(2, date('now', '-4 days'), 8, 2, 2, 'Excelente día, tiempo con familia'),
(2, date('now', '-3 days'), 6, 4, 4, 'Día promedio'),
(2, date('now', '-2 days'), 7, 3, 3, 'Buen día, práctica de meditación'),
(2, date('now', '-1 days'), 6, 5, 4, 'Algo de estrés laboral');

-- Create indexes for better performance
CREATE INDEX idx_user_assessments_user_id ON user_assessments(user_id);
CREATE INDEX idx_user_assessments_completed_at ON user_assessments(completed_at);
CREATE INDEX idx_daily_tracking_user_date ON daily_tracking(user_id, tracking_date);
CREATE INDEX idx_alerts_user_id ON alerts(user_id);
CREATE INDEX idx_resources_category ON resources(category);