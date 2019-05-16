import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { InstructorinvitationComponent } from './instructorinvitation.component';

describe('InstructorinvitationComponent', () => {
  let component: InstructorinvitationComponent;
  let fixture: ComponentFixture<InstructorinvitationComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ InstructorinvitationComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(InstructorinvitationComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
