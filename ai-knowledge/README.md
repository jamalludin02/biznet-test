# AI Knowledge Chat Frontend

Vue.js frontend application for AI chat interface using Ollama with Gemma3:1b model.

## 🚀 Quick Start

### Using Docker (Recommended)
```bash
# From project root
docker-compose up -d ai-knowledge-frontend
```

### Local Development
```bash
cd ai-knowledge
npm install
npm run dev
```

## 🏗️ Architecture

```
┌─────────────────┐    ┌─────────────────┐
│   Vue.js App    │    │   Ollama AI     │
│   (Port 3000)   │◄──►│   (Port 11434)  │
└─────────────────┘    └─────────────────┘
         ▲                       ▲
         │                       │
         └───────────────────────┘
                    │
         ┌─────────────────┐
         │  Nginx Proxy    │
         │   (Port 80)     │
         └─────────────────┘
```

## 📁 Structure

```
ai-knowledge/
├── src/
│   ├── App.vue        # Main chat component
│   ├── main.js        # Vue entry point
│   └── style.css      # Tailwind styles
├── Dockerfile         # Frontend container
└── package.json       # Dependencies
```

## 🌐 Access

- **Local Development**: http://localhost:3000
- **Docker**: http://localhost:3000

## 🛠️ Development

### Prerequisites
- Node.js 18+ (for local development)
- Ollama service running on port 11434

### Commands
```bash
npm install          # Install dependencies
npm run dev         # Start development server
npm run build       # Build for production
npm run preview     # Preview production build
```

## 🔗 Dependencies

- **Vue.js 3** - Frontend framework
- **Tailwind CSS** - Styling
- **@vueuse/core** - Vue composition utilities

## 📝 Notes

- Requires Ollama service running on `localhost:11434`
- Model `gemma3:1b` must be available in Ollama
- CORS is handled by direct API calls to Ollama 