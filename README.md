# PASS - Plataforma de Autoevaluación y Seguimiento Psicológico

Una plataforma web completa para la autoevaluación y seguimiento de la salud mental, desarrollada con PHP puro y MySQL.

## 🌟 Características Principales

- **Autoevaluaciones Clínicas**: Cuestionarios estandarizados GAD-7 (ansiedad) y PHQ-9 (depresión)
- **Seguimiento Diario**: Registro de estado de ánimo, estrés y ansiedad
- **Visualización de Datos**: Gráficas de progreso con Chart.js
- **Recursos Educativos**: Técnicas de mindfulness, ejercicios y artículos
- **Sistema de Alertas**: Detección automática de niveles críticos
- **Privacidad y Seguridad**: Encriptación de datos sensibles
- **Diseño Responsivo**: Interfaz adaptable con Bootstrap 5
- **Panel de Administración**: Gestión de contenido y usuarios

## 🛠️ Tecnologías Utilizadas

- **Backend**: PHP 7+ (puro, sin frameworks)
- **Base de Datos**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript
- **Framework CSS**: Bootstrap 5
- **Gráficas**: Chart.js
- **Autenticación**: Sesiones PHP con password_hash()
- **Arquitectura**: MVC (Modelo-Vista-Controlador)

## 📋 Requisitos del Sistema

- Apache 2.4+ con mod_rewrite habilitado
- PHP 7.4+ con extensiones:
  - PDO
  - MySQL
  - JSON
  - Session
- MySQL 5.7+ o MariaDB 10.2+
- 50MB de espacio en disco

## 🚀 Instalación

### 1. Descargar el Proyecto

```bash
git clone https://github.com/danjohn007/pass.git
cd pass
```

### 2. Configurar la Base de Datos

1. Crear la base de datos MySQL:
```sql
CREATE DATABASE pass_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Crear usuario de base de datos:
```sql
CREATE USER 'pass_user'@'localhost' IDENTIFIED BY 'pass_password123';
GRANT ALL PRIVILEGES ON pass_db.* TO 'pass_user'@'localhost';
FLUSH PRIVILEGES;
```

3. Importar el esquema de la base de datos:
```bash
mysql -u pass_user -p pass_db < database/schema.sql
```

### 3. Configurar Apache

#### Opción A: Instalar en DocumentRoot
Copiar todos los archivos a `/var/www/html/pass/`

#### Opción B: Instalar en subdirectorio
1. Crear directorio: `mkdir /var/www/html/mi-directorio`
2. Copiar archivos al directorio creado
3. El sistema detectará automáticamente la URL base

### 4. Configurar Permisos

```bash
# En el directorio del proyecto
chmod 755 -R .
chmod 644 .htaccess
```

### 5. Verificar mod_rewrite

Asegurar que mod_rewrite esté habilitado en Apache:
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### 6. Configurar la Base de Datos (si es necesario)

Editar `config/config.php` si necesitas cambiar las credenciales:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'pass_db');
define('DB_USER', 'pass_user');
define('DB_PASS', 'pass_password123');
```

## 🔧 Configuración Avanzada

### URL Base Automática

El sistema detecta automáticamente la URL base según el directorio de instalación. No requiere configuración manual.

### Variables de Entorno

Principales configuraciones en `config/config.php`:

```php
// Configuración de la aplicación
define('APP_NAME', 'PASS - Plataforma de Autoevaluación y Seguimiento Psicológico');
define('TIMEZONE', 'America/Mexico_City');

// Configuración de seguridad
define('SESSION_LIFETIME', 3600); // 1 hora
define('PASSWORD_MIN_LENGTH', 8);
define('ENCRYPTION_KEY', 'tu_clave_secreta_aqui'); // ¡Cambiar en producción!
```

### Configuración de Producción

1. **Deshabilitar errores de PHP**:
```php
error_reporting(0);
ini_set('display_errors', 0);
```

2. **Habilitar HTTPS** (descomentar en .htaccess):
```apache
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

3. **Cambiar clave de encriptación**:
```php
define('ENCRYPTION_KEY', 'tu_clave_super_segura_aqui');
```

## 👤 Usuarios de Prueba

El sistema incluye usuarios de demostración:

| Email | Contraseña | Rol |
|-------|------------|-----|
| admin@pass.com | password123 | Administrador |
| user@example.com | password123 | Usuario |
| maria@example.com | password123 | Usuario |

## 🏗️ Estructura del Proyecto

```
pass/
├── app/
│   ├── controllers/     # Controladores MVC
│   ├── models/         # Modelos de datos
│   └── views/          # Vistas/Templates
├── config/
│   ├── config.php      # Configuración principal
│   └── database.php    # Conexión a BD
├── database/
│   └── schema.sql      # Esquema de la BD
├── public/
│   ├── css/           # Archivos CSS personalizados
│   ├── js/            # JavaScript personalizado
│   └── images/        # Imágenes del sitio
├── .htaccess          # Configuración Apache
├── index.php          # Punto de entrada
└── README.md          # Este archivo
```

## 🔒 Seguridad

- ✅ Protección contra SQL Injection (PDO con prepared statements)
- ✅ Protección XSS (htmlspecialchars)
- ✅ Validación y sanitización de inputs
- ✅ Sesiones seguras con httponly y secure flags
- ✅ Headers de seguridad (X-Frame-Options, X-XSS-Protection, etc.)
- ✅ Encriptación de datos sensibles
- ✅ Protección de archivos de configuración

## 📊 Funcionalidades

### Usuarios
- ✅ Registro e inicio de sesión
- ✅ Perfiles de usuario con datos demográficos
- ✅ Gestión de sesiones seguras

### Evaluaciones
- ✅ Cuestionario GAD-7 (Ansiedad)
- ✅ Cuestionario PHQ-9 (Depresión)
- ✅ Cálculo automático de puntuaciones
- ✅ Interpretación de resultados
- ✅ Historial de evaluaciones

### Seguimiento
- ✅ Registro diario de estado de ánimo
- ✅ Seguimiento de estrés y ansiedad
- ✅ Visualización gráfica del progreso
- ✅ Notas personales

### Recursos
- ✅ Biblioteca de técnicas y ejercicios
- ✅ Artículos psicoeducativos
- ✅ Recursos categorizados
- ✅ Enlaces a recursos externos

### Administración
- ✅ Panel de administración
- ✅ Gestión de usuarios
- ✅ Gestión de contenido
- ✅ Estadísticas del sistema

## 🚨 Consideraciones Importantes

> **⚠️ AVISO MÉDICO**: Esta plataforma es una herramienta de apoyo y autoevaluación. NO sustituye la consulta, diagnóstico o tratamiento médico profesional. Si experimentas pensamientos suicidas o crisis emocional, busca ayuda profesional inmediata.

### Cumplimiento Normativo

- Compatible con principios de GDPR
- Datos de salud mental encriptados
- Consentimiento informado obligatorio
- Derecho al olvido implementable

## 🐛 Solución de Problemas

### Error 500 - Internal Server Error
- Verificar permisos de archivos
- Revisar configuración de la base de datos
- Comprobar logs de Apache/PHP

### URLs no funcionan (404)
- Verificar que mod_rewrite esté habilitado
- Revisar configuración de .htaccess
- Comprobar configuración de VirtualHost

### Error de conexión a base de datos
- Verificar credenciales en config/config.php
- Asegurar que MySQL esté ejecutándose
- Comprobar que la base de datos existe

## 📞 Soporte

Para reportar errores o solicitar características:
- GitHub Issues: [Crear nuevo issue](https://github.com/danjohn007/pass/issues)
- Email: soporte@pass.com

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 🤝 Contribuciones

Las contribuciones son bienvenidas. Por favor:
1. Fork el proyecto
2. Crea una rama para tu característica (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

---

**Desarrollado con ❤️ para el bienestar mental**
