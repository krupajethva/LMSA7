import { TestBed, inject } from '@angular/core/testing';

import { CertificatetemplateService } from './certificatetemplate.service';

describe('CertificatetemplateService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [CertificatetemplateService]
    });
  });

  it('should be created', inject([CertificatetemplateService], (service: CertificatetemplateService) => {
    expect(service).toBeTruthy();
  }));
});
