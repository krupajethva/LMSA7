import { TestBed, inject } from '@angular/core/testing';

import { RegisterAdminInvitedService } from './register-admin-invited.service';

describe('RegisterAdminInvitedService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [RegisterAdminInvitedService]
    });
  });

  it('should be created', inject([RegisterAdminInvitedService], (service: RegisterAdminInvitedService) => {
    expect(service).toBeTruthy();
  }));
});
