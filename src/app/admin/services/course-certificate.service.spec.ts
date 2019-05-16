import { TestBed, inject } from '@angular/core/testing';

import { CourseCertificateService } from './course-certificate.service';

describe('CourseCertificateService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [CourseCertificateService]
    });
  });

  it('should be created', inject([CourseCertificateService], (service: CourseCertificateService) => {
    expect(service).toBeTruthy();
  }));
});
