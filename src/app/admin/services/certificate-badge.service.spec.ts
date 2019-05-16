import { TestBed, inject } from '@angular/core/testing';

import { CertificateBadgeService } from './certificate-badge.service';

describe('CertificateBadgeService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [CertificateBadgeService]
    });
  });

  it('should be created', inject([CertificateBadgeService], (service: CertificateBadgeService) => {
    expect(service).toBeTruthy();
  }));
});
