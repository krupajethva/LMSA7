import { TestBed, inject } from '@angular/core/testing';

import { ImportfiledataService } from './importfiledata.service';

describe('ImportfiledataService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [ImportfiledataService]
    });
  });

  it('should be created', inject([ImportfiledataService], (service: ImportfiledataService) => {
    expect(service).toBeTruthy();
  }));
});
