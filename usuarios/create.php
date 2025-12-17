<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- React y ReactDOM -->
    <script crossorigin src="https://unpkg.com/react@18/umd/react.development.js"></script>
    <script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
    <!-- Babel para JSX -->
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .success-animation {
            animation: fadeOut 5s forwards;
        }
        @keyframes fadeOut {
            0% {opacity: 1;}
            70% {opacity: 1;}
            100% {opacity: 0; display: none;}
        }
        h2 {
            color: #0d6efd;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Registrar Nuevo Usuario</h2>
        <div id="root"></div>
    </div>

    <script type="text/babel">
        // Usamos React y ReactDOM desde el global (ya que los cargamos por CDN)
        const { useState } = React;

        function RegisterForm() {
            const [formData, setFormData] = useState({
                nombres: '',
                email: '',
                id_rol: '1',
                password_user: '',
                password_repeat: ''
            });
            
            const [errors, setErrors] = useState({});
            const [isSubmitting, setIsSubmitting] = useState(false);
            const [message, setMessage] = useState('');
            const [success, setSuccess] = useState(false);

            const handleChange = (e) => {
                const { name, value } = e.target;
                setFormData({ ...formData, [name]: value });

                if (errors[name]) {
                    setErrors({ ...errors, [name]: '' });
                }
            };

            const validateForm = () => {
                const newErrors = {};
                
                if (!formData.nombres.trim()) {
                    newErrors.nombres = 'El nombre es obligatorio';
                }
                
                if (!formData.email.trim()) {
                    newErrors.email = 'El email es obligatorio';
                } else if (!/\S+@\S+\.\S+/.test(formData.email)) {
                    newErrors.email = 'El email no es válido';
                }
                
                if (!formData.password_user) {
                    newErrors.password_user = 'La contraseña es obligatoria';
                } else if (formData.password_user.length < 6) {
                    newErrors.password_user = 'La contraseña debe tener al menos 6 caracteres';
                }
                
                if (formData.password_user !== formData.password_repeat) {
                    newErrors.password_repeat = 'Las contraseñas no coinciden';
                }
                
                setErrors(newErrors);
                return Object.keys(newErrors).length === 0;
            };

            const redirectToUserList = () => {
                setTimeout(() => {
                    window.location.href = 'index.php'; 
                }, 2000);
            };

            const handleSubmit = async (e) => {
                e.preventDefault();
                
                if (!validateForm()) return;

                setIsSubmitting(true);
                setMessage('');
                
                console.log('Datos a enviar:', formData);

                try {
                    const response = await fetch('../api/usuarios/create.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(formData)
                    });

                    const data = await response.json();

                    if (data.success) {
                        setMessage('Usuario registrado con éxito. Redirigiendo...');
                        setSuccess(true);
                        redirectToUserList();
                    } else {
                        setMessage('Error: ' + data.message);
                        setSuccess(false);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    setMessage('Error de conexión. Intente nuevamente.');
                    setSuccess(false);
                } finally {
                    setIsSubmitting(false);
                }
            };

            return (
                <form onSubmit={handleSubmit}>
                    {message && (
                        <div className={`alert ${success ? 'alert-success success-animation' : 'alert-danger'}`}>
                            {message}
                        </div>
                    )}
                    
                    <div className="mb-3">
                        <label htmlFor="nombres" className="form-label">Nombres Completos</label>
                        <input
                            type="text"
                            className={`form-control ${errors.nombres ? 'is-invalid' : ''}`}
                            id="nombres"
                            name="nombres"
                            value={formData.nombres}
                            onChange={handleChange}
                            placeholder="Escriba aquí el nombre del nuevo usuario..."
                        />
                        {errors.nombres && <div className="invalid-feedback">{errors.nombres}</div>}
                    </div>
                    
                    <div className="mb-3">
                        <label htmlFor="email" className="form-label">Email</label>
                        <input
                            type="email"
                            className={`form-control ${errors.email ? 'is-invalid' : ''}`}
                            id="email"
                            name="email"
                            value={formData.email}
                            onChange={handleChange}
                            placeholder="Escriba aquí el correo del nuevo usuario..."
                        />
                        {errors.email && <div className="invalid-feedback">{errors.email}</div>}
                    </div>
                    
                    <div className="mb-3">
                        <label htmlFor="rol" className="form-label">Rol del Usuario</label>
                        <select
                            className="form-control"
                            id="id_rol"
                            name="id_rol"
                            value={formData.id_rol}
                            onChange={handleChange}
                        >
                            <option value="1">Administrador</option>
                            <option value="3">Vendedor</option>
                            <option value="4">Contador</option>
                            <option value="5">Almacén</option>
                        </select>
                    </div>
                    
                    <div className="mb-3">
                        <label htmlFor="password_user" className="form-label">Contraseña</label>
                        <input
                            type="password"
                            className={`form-control ${errors.password_user ? 'is-invalid' : ''}`}
                            id="password_user"
                            name="password_user"
                            value={formData.password_user}
                            onChange={handleChange}
                            placeholder="Escriba una contraseña segura..."
                        />
                        {errors.password_user && <div className="invalid-feedback">{errors.password_user}</div>}
                    </div>
                    
                    <div className="mb-3">
                        <label htmlFor="password_repeat" className="form-label">Repita la Contraseña</label>
                        <input
                            type="password"
                            className={`form-control ${errors.password_repeat ? 'is-invalid' : ''}`}
                            id="password_repeat"
                            name="password_repeat"
                            value={formData.password_repeat}
                            onChange={handleChange}
                            placeholder="Repita la contraseña..."
                        />
                        {errors.password_repeat && <div className="invalid-feedback">{errors.password_repeat}</div>}
                    </div>
                    
                    <div className="d-flex justify-content-between">
                        <a href="index.php" className="btn btn-secondary">Cancelar</a>
                        <button 
                            type="submit" 
                            className="btn btn-primary"
                            disabled={isSubmitting}
                        >
                            {isSubmitting ? 'Registrando...' : 'Registrar Usuario'}
                        </button>
                    </div>
                </form>
            );
        }

        // Renderizar
        const root = ReactDOM.createRoot(document.getElementById('root'));
        root.render(<RegisterForm />);
    </script>
</body>
</html>