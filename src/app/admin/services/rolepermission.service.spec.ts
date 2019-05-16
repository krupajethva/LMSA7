import { TestBed, inject } from '@angular/core/testing';

import { RolepermissionService } from './rolepermission.service';

describe('RolepermissionService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [RolepermissionService]
    });
  });

  it('should be created', inject([RolepermissionService], (service: RolepermissionService) => {
    expect(service).toBeTruthy();
  }));
});
