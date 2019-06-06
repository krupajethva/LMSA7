import { TestBed } from '@angular/core/testing';

import { InvitationacceptdeclineService } from './invitationacceptdecline.service';

describe('InvitationacceptdeclineService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: InvitationacceptdeclineService = TestBed.get(InvitationacceptdeclineService);
    expect(service).toBeTruthy();
  });
});
