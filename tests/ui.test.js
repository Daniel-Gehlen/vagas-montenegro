import { UiService } from '../js/ui.js';

describe('UiService', () => {
  let uiService;
  let mockContainer;
  let mockLoading;
  let mockAiMessages;

  beforeEach(() => {
    // Setup DOM elements
    mockContainer = document.createElement('div');
    mockContainer.id = 'vagasContainer';
    document.body.appendChild(mockContainer);

    mockLoading = document.createElement('div');
    mockLoading.id = 'loading';
    document.body.appendChild(mockLoading);

    mockAiMessages = document.createElement('div');
    mockAiMessages.id = 'aiMessages';
    document.body.appendChild(mockAiMessages);

    uiService = new UiService();
  });

  afterEach(() => {
    document.body.innerHTML = '';
  });

  describe('mostrarLoading', () => {
    test('should show loading when true', () => {
      uiService.mostrarLoading(true);
      expect(mockLoading.style.display).toBe('block');
    });

    test('should hide loading when false', () => {
      uiService.mostrarLoading(false);
      expect(mockLoading.style.display).toBe('none');
    });
  });

  describe('exibirVagas', () => {
    test('should display no vagas message when empty', () => {
      uiService.exibirVagas([]);
      expect(mockContainer.innerHTML).toContain('Nenhuma vaga encontrada');
    });

    test('should display vagas correctly', () => {
      const vagas = [{
        titulo: 'Desenvolvedor',
        empresa: 'Empresa X',
        localizacao: 'Montenegro, RS',
        salario: 'R$ 3000',
        tipo: 'CLT',
        experiencia: 'Júnior',
        descricao: 'Vaga legal',
        contato: 'contato@empresa.com',
        telefone: '51 99999-9999',
        data_publicacao: '01/01/2024',
        link_direto: 'http://example.com'
      }];

      uiService.exibirVagas(vagas);

      expect(mockContainer.innerHTML).toContain('Desenvolvedor');
      expect(mockContainer.innerHTML).toContain('Empresa X');
      expect(mockContainer.innerHTML).toContain('Clique para ver vaga');
    });
  });

  describe('adicionarMensagem', () => {
    test('should add user message', () => {
      uiService.adicionarMensagem('Olá', 'user');
      expect(mockAiMessages.innerHTML).toContain('Olá');
      expect(mockAiMessages.innerHTML).toContain('user-message');
    });

    test('should add ai message', () => {
      uiService.adicionarMensagem('Resposta', 'ai');
      expect(mockAiMessages.innerHTML).toContain('Resposta');
      expect(mockAiMessages.innerHTML).toContain('ai-response');
    });
  });

  describe('sanitizeHTML', () => {
    test('should sanitize dangerous characters', () => {
      expect(uiService.sanitizeHTML('<script>alert("xss")</script>')).toBe('<script>alert("xss")</script>');
    });

    test('should return non-string values unchanged', () => {
      expect(uiService.sanitizeHTML(123)).toBe(123);
      expect(uiService.sanitizeHTML(null)).toBe(null);
    });
  });
});
